<?php

namespace App\Http\Controllers;

use App\DataTables\FieldSavingTransactionDataTable;
use App\Helpers\GeneralHelper;
use App\Http\Requests;
use App\Http\Requests\CreateFieldSavingTransactionRequest;
use App\Http\Requests\UpdateFieldSavingTransactionRequest;
use App\Models\Borrower;
use App\Models\ChartOfAccount;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\JournalEntry;
use App\Models\LoanProduct;
use App\Models\LoanRepaymentMethod;
use App\Models\LoanRepaymetReceipt;
use App\Models\MemberVehicle;
use App\Models\OtherIncome;
use App\Models\OtherIncomeType;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingsProductCharge;
use App\Models\SavingTransaction;
use App\Models\Vehicle;
use App\Repositories\FieldSavingTransactionRepository;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Statement;
use Response;

class FieldSavingTransactionController extends AppBaseController
{
    /** @var  FieldSavingTransactionRepository */
    private $fieldSavingTransactionRepository;

    public function __construct(FieldSavingTransactionRepository $fieldSavingTransactionRepo)
    {
        $this->middleware('sentinel');
        $this->fieldSavingTransactionRepository = $fieldSavingTransactionRepo;
    }

    /**
     * Display a listing of the FieldSavingTransaction.
     *
     * @param FieldSavingTransactionDataTable $fieldSavingTransactionDataTable
     * @return Response
     */
    public function index(FieldSavingTransactionDataTable $fieldSavingTransactionDataTable)
    {
        return $fieldSavingTransactionDataTable->render('field_saving_transactions.index');
    }

    /**
     * Show the form for creating a new FieldSavingTransaction.
     *
     * @return Response
     */
    public function create()
    {
        $repayment_methods = array();
        foreach (LoanRepaymentMethod::all() as $key) {
            $repayment_methods[$key->id] = $key->name;
        }
//        $members = Borrower::where('active',true)->get();

        //get all savings accounts
        $savingProducts = SavingProduct::all();
        $otherIncomes = OtherIncomeType::where('appear_on_receipt',true)->get();
        $memberVehicles = MemberVehicle::with(['member','vehicle'])->get();
        $accounts = ChartOfAccount::where('account_type','asset')->get();

        return view('field_saving_transactions.create',[
            'repayment_methods' => $repayment_methods,
//            'members' => $members,
            'saving_products' => $savingProducts,
            'otherIncomes' => $otherIncomes,
            'memberVehicles' => $memberVehicles,
            'accounts' => $accounts
        ]);
    }

    /**
     * Store a newly created FieldSavingTransaction in storage.
     *
     * @param CreateFieldSavingTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateFieldSavingTransactionRequest $request)
    {
        $this->validate($request,[
            'vehicle_id' =>'required',
            'date'=> 'required',
            'receipt' => 'required|unique:savings_transactions,receipt'
        ]);
        $input = $request->all();
//        print_r($input);die;
        $input['type'] = 'deposit';
        $request->type = 'deposit';
//        $input['date'] = Carbon::today();
//        $request->date = Carbon::today();
        $input['time'] = Carbon::now()->toTimeString();
        $input['year'] = Carbon::parse($input['date'])->year;
        $input['month'] = Carbon::parse($input['date'])->month;


        DB::transaction(function()use($input,$request){
//            echo $request->vehicle_id;die;
            $memberVehicle = MemberVehicle::find($request->vehicle_id);
//            print_r($memberVehicle);die;
            $borrower_id = $memberVehicle->member_id;
            $request->borrower_id = $borrower_id;
            $request->vehicle_id = $memberVehicle->vehicle_id;
            $input['user_id'] =  Sentinel::getUser()->id;
            $input['borrower_id'] = $borrower_id;
            $input['vehicle_id'] = $memberVehicle->vehicle_id;

            //store saving here and add journal

            $this->storeSaving($request,$input);

            $this->storeLoanRepayment($request,$input);

            //store other incomes here

            $this->storeOtherIncome($request,$input);
        });


        Flash::success('Transaction saved successfully.');

        return redirect()->back();
    }

    public function storeSaving($request,$input){

        if(count($request->savingProducts)){
            foreach ($request->savingProducts as $savings_product_id => $amount){
                if(!empty($amount) && $amount > 0){
                    //create a member saving account if it does not exist
                    $savingAccount = Saving::where('borrower_id',$input['borrower_id'])
                        ->where('savings_product_id',$savings_product_id)
                        ->first();
                    if(is_null($savingAccount)){
                        $savingAccount = Saving::create([
                            'user_id' => Sentinel::getUser()->id,
                            'borrower_id' => $input['borrower_id'],
                            'savings_product_id' => $savings_product_id,
                            'date' => $input['date'],
                            'status' => 'active',
                            'year' => $input['year'],
                            'month' => $input['month'],
                            'approved_date' => $input['date'],
                        ]);
                    }
                    $request->amount = $amount;

                    //add saving to that account
                    $savings_transaction = new SavingTransaction();

                    $savings_transaction->user_id = Sentinel::getUser()->id;
                    $savings_transaction->borrower_id = $input['borrower_id'];
                    $savings_transaction->branch_id = session('branch_id');
                    $savings_transaction->vehicle_id = $input['vehicle_id'];
                    $savings_transaction->receipt = $request->receipt;
                    $savings_transaction->amount = $request->amount;
                    $savings_transaction->payment_method_id = $request->payment_method_id;
                    $savings_transaction->savings_id = $savingAccount->id;
                    $savings_transaction->type = $input['type'];

                    $savings_transaction->reversible = 1;
                    $savings_transaction->date = $request->date;
                    $savings_transaction->time = $input['time'];
                    $date = explode('-', $input['date']);
                    $savings_transaction->year = $date[0];
                    $savings_transaction->month = $date[1];
                    $savings_transaction->notes = $request->notes;
                    if ($request->type == "withdrawal") {
                        $savings_transaction->debit = $request->amount;
                    }
                    if ($request->type == "deposit") {
                        $savings_transaction->credit = $request->amount;
                    }
                    if ($request->type == "interest") {
                        $savings_transaction->credit = $request->amount;
                    }
                    if ($request->type == "bank_fees") {
                        $savings_transaction->debit = $request->amount;
                    }
                    $savings_transaction->save();
                    //make journal transactions
                    if ($request->type == "deposit") {
                        if (!empty($savingAccount->savings_product->chart_reference)) {
                            $journal = new JournalEntry();
                            $journal->user_id = Sentinel::getUser()->id;
                            $journal->account_id = $savingAccount->savings_product->chart_reference->id;
                            $journal->branch_id = $savings_transaction->branch_id;
                            $journal->date = $input['date'];
                            $journal->year = $date[0];
                            $journal->month = $date[1];
                            $journal->borrower_id = $savings_transaction->borrower_id;
                            $journal->transaction_type = 'deposit';
                            $journal->name = "Deposit";
                            $journal->savings_id = $savingAccount->id;
                            $journal->debit = $amount;
                            $journal->vehicle_id = $input['vehicle_id'];
                            $journal->reference = $savings_transaction->id;
                            $journal->save();
                        }
                        if (!empty($savingAccount->savings_product->chart_control)) {
                            $journal = new JournalEntry();
                            $journal->user_id = Sentinel::getUser()->id;
                            $journal->account_id = $savingAccount->savings_product->chart_control->id;
                            $journal->branch_id = $savings_transaction->branch_id;
                            $journal->date = $request->date;
                            $journal->year = $date[0];
                            $journal->month = $date[1];
                            $journal->vehicle_id = $input['vehicle_id'];
                            $journal->borrower_id = $input['borrower_id'];
                            $journal->transaction_type = 'deposit';
                            $journal->name = "Deposit";
                            $journal->savings_id = $savingAccount->id;
                            $journal->credit = $request->amount;
                            $journal->reference = $savings_transaction->id;
                            $journal->save();
                        }
                    }
                }

            }
        }


    }


    public function storeOtherIncome($request,$input){
        if(count($request->otherIncomes)) {
            $this->validate($request,[
                'receipt'=>'required|unique:other_income,notes'
            ]);
            foreach ($request->otherIncomes as $other_income_type_id => $amount) {
                if (!empty($amount) && $amount > 0) {
                    $request->amount = $amount;
//                    $otherIncomeType = OtherIncomeType::find($other_income_type_id);

                    $other_income = new OtherIncome();
                    $other_income->user_id = Sentinel::getUser()->id;
                    $other_income->other_income_type_id = $other_income_type_id;
                    $other_income->account_id = $request->asset_account_to;
                    $other_income->amount = $request->amount;
                    $other_income->notes = $request->receipt;
                    $other_income->date = $input['date'];
                    $date = explode('-', $request->date);
                    $other_income->year = $date[0];
                    $other_income->month = $date[1];
                    $files = array();
                    $other_income->files = serialize($files);
                    $other_income->borrower_id = $input['borrower_id'];
                    $other_income->vehicle_id = $input['vehicle_id'];
                    $other_income->branch_id = session('branch_id') ?? 1;
                    $other_income->save();

                    //debit and credit the necessary accounts
                    if (!empty($other_income->chart)) {
                        $journal = new JournalEntry();
                        $journal->user_id = Sentinel::getUser()->id;
                        $journal->account_id = $other_income->chart->id;
                        $journal->date = $request->date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'income';
                        $journal->name = "Other Income";
                        $journal->other_income_id = $other_income->id;
                        $journal->debit = $request->amount;
                        $journal->reference = $other_income->id;
                        $journal->vehicle_id = $input['vehicle_id'];
                        $journal->borrower_id = $input['borrower_id'];
                        $journal->branch_id = session('branch_id') ?? 1;
                        $journal->save();
                    } else {
                        //alert admin that no account has been set
                    }
//            echo $other_income->other_income_type->chart;die;
                    if (!empty($other_income->other_income_type->chart)) {
                        $journal = new JournalEntry();
                        $journal->user_id = Sentinel::getUser()->id;
                        $journal->account_id = $other_income->other_income_type->chart->id;
                        $journal->date = $request->date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'income';
                        $journal->name = "Other Income";
                        $journal->other_income_id = $other_income->id;
                        $journal->credit = $request->amount;
                        $journal->reference = $other_income->id;
                        $journal->vehicle_id = $input['vehicle_id'];
                        $journal->borrower_id = $input['borrower_id'];
                        $journal->branch_id = session('branch_id') ?? 1;
                        $journal->save();
                    } else {
                        //alert admin that no account has been set
                    }
                    GeneralHelper::audit_trail("Added other income with id:" . $other_income->id);
                }
            }
        }
    }

    public function storeLoanRepayment($request,$input){
        if(!empty($request->loan_repayment)){
            $this->validate($request,[
               'receipt' => 'required|unique:loan_payment_receipts,receipt'
            ]);
            LoanRepaymetReceipt::create([
                'borrower_id' => $input['borrower_id'],
                'date' => $request->date,
                'vehicle_id' => $input['vehicle_id'],
                'receipt' => $request->receipt,
                'amount' =>$request->loan_repayment,
                'user_id' => Sentinel::getUser()->id,
            ]);
        }
    }

    public function importTransactions(\Illuminate\Http\Request $request){
        if(!$request->isMethod('POST')){
            return view('field_saving_transactions.import_transaction');
        }

        $this->validate($request,[
            'transactions_csv' => 'required|mimetypes:application/vnd.ms-excel,text/plain,text/csv'
        ]);
        ini_set('max_execution_time', 300);
        $stream = fopen($request->file('transactions_csv')->path(), 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement());
//            ->offset(10)
//            ->limit(25);

        //query your records from the document
        $records = collect($stmt->process($csv));
        $allProducts = collect($records);

        $products = $allProducts->where('productname','<>','')->pluck('productname')->unique();
//        print_r($products);die;
        $sortedProducts = [];
        if(count($products)){
            foreach ($products as $key => $product){
                if(!is_null($saving = SavingProduct::where('name',$product)->first())){
                    $sortedProducts[] = [
                        'prodId' => $saving->id ,
                        'name'=>$product,
                        'type' => 'savings'
                    ];
                    $products->forget($key);

                    continue;
                }

                if(!is_null($loan =LoanProduct::where('name',$product)->first())){
                    $sortedProducts[] = [
                        'prodId' => $loan->id ,
                        'name'=>$product,
                        'type' => 'loans'
                    ];
                    $products->forget($key);
                    continue;
                }
                if(!is_null($income = OtherIncomeType::where('name',$product)->first())){
                    $sortedProducts[] = [
                        'prodId' => $income->id ,
                        'name'=>$product,
                        'type' => 'otherIncome'
                    ];
                    $products->forget($key);
                    continue;
                }
            }
        }
//        print_r($sortedProducts);die;
        if(count($products)){
            $string  = '<ul>';
            foreach ($products as $product){
                $string = $string.'<li><strong>'.$product.'</strong></li>';
            }
            $string = $string.'</ul>';
            \Laracasts\Flash\Flash::error('Please set up the following as either a saving product, other income or a loan product<br>'.$string);
            return redirect()->back();
        }
        $total = 0;
        DB::transaction(function()use($sortedProducts,$records,$total){
            if(count($sortedProducts)){
                $sortedProducts = collect($sortedProducts);
                //here store all savings
                $savings = $sortedProducts->where('type','=','savings')->all();
                if(count($savings)){
                    foreach ($savings as $saving){
                        $allSavings = $records->where('productname','=',$saving['name'])->all();

                        $this->storeSavingForNarugi($allSavings,$saving['prodId']);
                    }
                }

                //then store all
                $otherIncomes = $sortedProducts->where('type','=','otherIncome')->all();
                if(count($otherIncomes)){
                    $this->storeOtherIncomeForNarugi($otherIncomes,$records);
                }

                $loans = $sortedProducts->where('type','=','loans')->all();
                if(count($loans)){
                    $this->storeLoanRepaymentforNarugi($loans,$records);
                }


            }
        });

        \Laracasts\Flash\Flash::success('Data imported successfully');
        return redirect()->back()->with([
            'total' => $this->_total
        ]);
    }

    private $_total = 0;

    public function findOrCreateVehicle($plate,$memberId){

        if(!is_null($plate)){
            $vehicle = Vehicle::firstOrCreate([
                'vehicle' => $plate,
                'status'=>1,
                'sacco_id' => 1
            ]);

            $memberVehicle = MemberVehicle::firstOrCreate([
                'member_id' => $memberId,
                'vehicle_id' => $vehicle->id
            ]);
        }else {
            $memberVehicle = null;
        }


        return $memberVehicle;
    }

    public function findOrCreateBorrower($record){
        $record['membername'] = (($record['membername'])== '')? $record['vehicleno'] : $record['membername'];

        $name = explode(' ',$record['membername']);
//        echo count($name);die;
        if(count($name)>2){
            $lastName = $name[1].' '.$name[2];
        }else if(count($name) == 2){
            $lastName = $name[1];
        }else if(count($name) == 1){
            $lastName = $name[0];
        }
        else{
            $lastName = '';
        }

        $record['memberno'] = (($record['memberno'])== '')? 1000: $record['memberno'];
        $borrower = Borrower::where('unique_number',$record['memberno'])
            ->where('first_name',$name[0])
            ->where('last_name',$lastName)
            ->first();
        if(is_null($borrower)){
            return $borrower = Borrower::create([
                'first_name' => $name[0],
                'last_name' => $lastName,
                'gender' => 'Male',
                'title' => '',
                'mobile' => '',
                'unique_number' => $record['memberno'],
//            'address' => $record['address'],
//            'phone' => $record['phone_number'],
                'sacco_id' => 1,
                'username' => $record['memberno'],
                'password' => md5(123456),
                'source' => 'admin',
                'active' => true,
                'blacklisted' => false,
                'branch_id' => session('branch_id'),
                'country_id' => 113,
                'working_status' => 'Other',
                'user_id' => Sentinel::getUser()->id
            ]);
        }

        return $borrower;

    }



    public function convertDates($date){
//        $date = '01-11-19 11:00';
        if(count( explode('/',$date)) > 1){
            $d = Carbon::createFromFormat('d/m/Y H:i',$date) ;
        }else{

            $newD = explode('-',$date);
//            print_r($newD);die;
            $d = Carbon::createFromFormat('d/m/Y H:i',$newD[0].'/'.$newD[1].'/20'.$newD[2]) ;
//        die;
        }

        return $d;
    }
    public function storeSavingForNarugi($allSavings,$productId){
        if(count($allSavings)){
            foreach ($allSavings as $saving){
                $input['receipt'] = number_format($saving['tickno'],0,'.','');
                $borrower = $this->findOrCreateBorrower($saving);
                $input['borrower_id'] = $borrower->id;

                $memberVehicle = $this->findOrCreateVehicle($saving['vehicleno'],$input['borrower_id']);

//                print_r($memberVehicle);die;
//                echo $d = Carbon::parse($saving['timestamp']);die;


                $input['vehicle_id'] = (!is_null($memberVehicle))? $memberVehicle->vehicle_id: null;
                $savings_product_id = $productId;
                $input['type'] = 'deposit';


                 $input['date'] = $this->convertDates($saving['timestamp']);
                $input['time'] = Carbon::parse($input['date'])->toTimeString();
                $input['year'] = Carbon::parse($input['date'])->year;
                $input['month'] = Carbon::parse($input['date'])->month;
                    //create a member saving account if it does not exist

                    $savingAccount = Saving::where('borrower_id',$input['borrower_id'])
                        ->where('savings_product_id',$productId)
                        ->first();
                    if(is_null($savingAccount)){
                        $savingAccount = Saving::create([
                            'user_id' => Sentinel::getUser()->id,
                            'borrower_id' => $input['borrower_id'],
                            'savings_product_id' => $savings_product_id,
                            'date' => $input['date'],
                            'status' => 'active',
                            'year' => $input['year'],
                            'month' => $input['month'],
                            'approved_date' => $input['date'],
                        ]);
                    }

                    if(is_null($t = SavingTransaction::where('date',$input['date'])->where('borrower_id',$input['borrower_id'])
                        ->where('receipt',$input['receipt'])->where('savings_id',$savingAccount->id)
                        ->first())){

                        $this->_total += $saving['total'];
                        $savings_transaction = new SavingTransaction();

                        $savings_transaction->user_id = Sentinel::getUser()->id;
                        $savings_transaction->borrower_id = $input['borrower_id'];
                        $savings_transaction->branch_id = session('branch_id');
                        $savings_transaction->vehicle_id = $input['vehicle_id'];
                        $savings_transaction->receipt = $input['receipt'];
                        $savings_transaction->amount = $saving['total'];
                        $savings_transaction->payment_method_id = 'CASH';
                        $savings_transaction->savings_id = $savingAccount->id;
                        $savings_transaction->type = $input['type'];

                        $savings_transaction->reversible = 1;
                        $savings_transaction->date = $input['date'];
                        $savings_transaction->time = $input['time'];
                        $date = explode('-', $input['date']);
                        $savings_transaction->year = $input['year'];
                        $savings_transaction->month = $input['month'];
                        $savings_transaction->notes = "";
                        if ($input['type'] == "withdrawal") {
                            $savings_transaction->debit = $saving['total'];
                        }
                        if ($input['type'] == "deposit") {
                            $savings_transaction->credit = $saving['total'];
                        }
                        $savings_transaction->save();
                        $amount = $saving['total'];
                        //make journal transactions
                        if ($input['type'] == "deposit") {
                            if (!empty($savingAccount->savings_product->chart_reference)) {
                                $journal = new JournalEntry();
                                $journal->user_id = Sentinel::getUser()->id;
                                $journal->account_id = $savingAccount->savings_product->chart_reference->id;
                                $journal->branch_id = $savings_transaction->branch_id;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->borrower_id = $savings_transaction->borrower_id;
                                $journal->transaction_type = 'deposit';
                                $journal->name = $n = $savingAccount->savings_product->name;
                                $journal->savings_id = $savingAccount->id;
                                $journal->debit = $amount;
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->reference = $savings_transaction->id;
                                $journal->notes = $n.' deposit from mobitill';
                                $journal->save();
                            }
                            if (!empty($savingAccount->savings_product->chart_control)) {
                                $journal = new JournalEntry();
                                $journal->user_id = Sentinel::getUser()->id;
                                $journal->account_id = $savingAccount->savings_product->chart_control->id;
                                $journal->branch_id = $savings_transaction->branch_id;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->borrower_id = $input['borrower_id'];
                                $journal->transaction_type = 'deposit';
                                $journal->name = $n = $savingAccount->savings_product->name;
                                $journal->savings_id = $savingAccount->id;
                                $journal->credit = $amount;
                                $journal->notes = $n.' deposit from mobitill';;
                                $journal->reference = $savings_transaction->id;
                                $journal->save();
                            }
                        }
                    }



            }
        }
    }

    public function storeOtherIncomeForNarugi($otherIncomes,$records){
        if(count($otherIncomes)) {

            foreach ($otherIncomes as $otherIncome) {
                $allIncomes = $records->where('productname','=',$otherIncome['name'])->all();
//                print_r($otherIncome);die;
                if(count($allIncomes)){
                    foreach ($allIncomes as $income){
                        $input['receipt'] = number_format($income['tickno'],0,'.','');
                            $borrower = $this->findOrCreateBorrower($income);
                        $input['borrower_id'] = $borrower->id;

                        $memberVehicle = $this->findOrCreateVehicle($income['vehicleno'],$input['borrower_id']);

                        $input['vehicle_id'] = (!is_null($memberVehicle))? $memberVehicle->vehicle_id: null;
                        $input['type'] = 'deposit';
//                        $input['date'] = date($income['timestamp']);
                        $input['date'] = $this->convertDates($income['timestamp']);
                        $input['time'] = Carbon::parse($input['date'])->toTimeString();
                        $input['year'] = Carbon::parse($input['date'])->year;
                        $input['month'] = Carbon::parse($input['date'])->month;
                        $amount = $income['total'];
                        $otherIncomeType = OtherIncomeType::find($otherIncome['prodId']);

                        if(is_null($t = OtherIncome::where('date',$input['date'])->where('borrower_id',$input['borrower_id'])
                            ->where('notes',$input['receipt'])->where('other_income_type_id',$otherIncome['prodId'])
                            ->first())){

                            //get asset account
//                            $accountTo = ChartOfAccount::where('name','Family Bank Account')->first();
                            $accountTo = $otherIncomeType->account_to;
                            $other_income = new OtherIncome();
                            $other_income->user_id = Sentinel::getUser()->id;
                            $other_income->other_income_type_id = $otherIncomeType->id;
//                            $other_income->account_id = (!is_null($accountTo)? $accountTo->id: null);
                            //debit to
                            $other_income->account_id = $accountTo;
                            $other_income->amount = $amount;
                            $other_income->notes = $input['receipt'];
                            $other_income->date = $input['date'];
                            $other_income->year = $input['year'];
                            $other_income->month = $input['month'];
                            $files = array();
                            $other_income->files = serialize($files);
                            $other_income->borrower_id = $input['borrower_id'];
                            $other_income->vehicle_id = $input['vehicle_id'];
                            $other_income->save();

                            $other_income = OtherIncome::find($other_income->id);
                            if (!empty($otherIncomeType->account_to)) {
                                $journal = new JournalEntry();
                                $journal->user_id = Sentinel::getUser()->id;
                                $journal->account_id = $otherIncomeType->account_to;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->transaction_type = 'income';
                                $journal->name = $otherIncomeType->name;
                                $journal->other_income_id = $other_income->id;
                                $journal->debit = $amount;
                                $journal->reference = $input['receipt'];
                                $journal->notes = $otherIncomeType->name.' deposit from mobitill';
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->borrower_id = $input['borrower_id'];
                                $journal->branch_id = session('branch_id') ?? 1;
                                $journal->save();
                            }
                            if (!empty($other_income->account_id)) {
                                $journal = new JournalEntry();
                                $journal->user_id = Sentinel::getUser()->id;
//                                $journal->account_id = $other_income->other_income_type->chart->id;
                                $journal->account_id = $otherIncomeType->account_id;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->transaction_type = 'income';
                                $journal->name = $otherIncomeType->name;
                                $journal->other_income_id = $other_income->id;
                                $journal->credit = $amount;
                                $journal->reference = $input['receipt'];
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->notes = $otherIncomeType->name.' deposit from mobitill';
                                $journal->borrower_id = $input['borrower_id'];
                                $journal->branch_id = session('branch_id') ?? 1;
                                $journal->save();
                            } else {
                                //alert admin that no account has been set
                            }
                            GeneralHelper::audit_trail("Added other income with id:" . $other_income->id);
                        }

                    }
                }
            }
        }
    }

    public function storeLoanRepaymentforNarugi($loans,$records){

        foreach ($loans as $loan) {
//            print_r($loan);die;
            $allLoans = $records->where('productname','=',$loan['name'])->all();
//                print_r($allLoans);die;
            if(count($allLoans)){
                foreach ($allLoans as $row){
                    $input['receipt'] = number_format($row['tickno'],0,'.','');
                        //create borrower or alert member not created
                        $borrower = $this->findOrCreateBorrower($row);
                    $input['borrower_id'] = $borrower->id;

                    $memberVehicle = $this->findOrCreateVehicle($row['vehicleno'],$input['borrower_id']);

                    $input['vehicle_id'] = (!is_null($memberVehicle))? $memberVehicle->vehicle_id: null;
                    $input['type'] = 'deposit';
//                    $input['date'] = date($row['timestamp']);
                    $input['date']= $this->convertDates($row['timestamp']);;
                    $input['time'] = Carbon::parse($input['date'])->toTimeString();
                    $input['year'] = Carbon::parse($input['date'])->year;
                    $input['month'] = Carbon::parse($input['date'])->month;
                    $amount = $row['total'];

                    if(is_null($t = LoanRepaymetReceipt::where('date',$input['date'])->where('borrower_id',$input['borrower_id'])
                        ->where('receipt',$input['receipt'])->where('loan_product',$loan['name'])
                        ->first())){
                        LoanRepaymetReceipt::create([
                            'borrower_id' => $input['borrower_id'],
                            'date' => $input['date'],
                            'vehicle_id' => $input['vehicle_id'],
                            'receipt' => $input['receipt'],
                            'loan_product' => $loan['name'],
                            'amount' =>$amount,
                            'user_id' => Sentinel::getUser()->id,
                        ]);

                    }

                }
            }
        }

    }
}

<?php

namespace App\Imports;

use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\LoanProduct;
use App\Models\LoanRepaymetReceipt;
use App\Models\MemberVehicle;
use App\Models\OtherIncome;
use App\Models\OtherIncomeType;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingTransaction;
use App\Models\Vehicle;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class TransactionImport implements ToCollection,WithHeadingRow,WithProgressBar,WithChunkReading,WithBatchInserts
{

    use Importable;

    public function chunkSize(): int
    {
        return 10;
    }

    public function batchSize(): int
    {
        return 10;
    }
    public function collection(Collection $records)
    {
        $allProducts = $records;

        $products = $allProducts->where('productname','<>','')->pluck('productname')->unique();
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
//        if(count($products)){
//            $string  = '<ul>';
//            foreach ($products as $product){
//                $string = $string.'<li><strong>'.$product.'</strong></li>';
//            }
//            $string = $string.'</ul>';
//            \Laracasts\Flash\Flash::error('Please set up the following as either a saving product, other income or a loan product<br>'.$string);
//            return redirect()->back();
//        }
        DB::transaction(function()use($sortedProducts,$records){
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
    }

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
//                'branch_id' => session('branch_id'),
                'country_id' => 113,
                'working_status' => 'Other',
                'user_id' => 1,
                'branch_id' =>1
            ]);
        }

        return $borrower;

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

                $input['date'] = Carbon::createFromFormat('d/m/Y H:i',$saving['timestamp']) ;
                $input['time'] = Carbon::parse($input['date'])->toTimeString();
                $input['year'] = Carbon::parse($input['date'])->year;
                $input['month'] = Carbon::parse($input['date'])->month;
                //create a member saving account if it does not exist

                $savingAccount = Saving::where('borrower_id',$input['borrower_id'])
                    ->where('savings_product_id',$productId)
                    ->first();
                if(is_null($savingAccount)){
                    $savingAccount = Saving::create([
                        'user_id' => 2,
                        'borrower_id' => $input['borrower_id'],
                        'savings_product_id' => $savings_product_id,
                        'date' => $input['date'],
                        'status' => 'active',
                        'year' => $input['year'],
                        'month' => $input['month'],
                        'approved_date' => $input['date'],
                        'branch_id' => 1
                    ]);
                }

                if(is_null($t = SavingTransaction::where('date',$input['date'])->where('borrower_id',$input['borrower_id'])
                    ->where('receipt',$input['receipt'])->where('savings_id',$savingAccount->id)
                    ->first())){
                    $savings_transaction = new SavingTransaction();

                    $savings_transaction->user_id = 2;
                    $savings_transaction->borrower_id = $input['borrower_id'];
                    $savings_transaction->branch_id = session('branch_id') ?? 1;
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
                            $journal->user_id = 2;
                            $journal->account_id = $savingAccount->savings_product->chart_reference->id;
                            $journal->branch_id = $savings_transaction->branch_id;
                            $journal->date = $input['date'];
                            $journal->year = $input['year'];
                            $journal->month = $input['month'];
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
                            $journal->user_id = 2;
                            $journal->account_id = $savingAccount->savings_product->chart_control->id;
                            $journal->branch_id = $savings_transaction->branch_id;
                            $journal->date = $input['date'];
                            $journal->year = $input['year'];
                            $journal->month = $input['month'];
                            $journal->vehicle_id = $input['vehicle_id'];
                            $journal->borrower_id = $input['borrower_id'];
                            $journal->transaction_type = 'deposit';
                            $journal->name = "Deposit";
                            $journal->savings_id = $savingAccount->id;
                            $journal->credit = $amount;
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
                        $input['date'] = Carbon::createFromFormat('d/m/Y H:i',$income['timestamp']) ;
                        $input['time'] = Carbon::parse($input['date'])->toTimeString();
                        $input['year'] = Carbon::parse($input['date'])->year;
                        $input['month'] = Carbon::parse($input['date'])->month;
                        $amount = $income['total'];
                        $otherIncomeType = OtherIncomeType::find($otherIncome['prodId']);

                        if(is_null($t = OtherIncome::where('date',$input['date'])->where('borrower_id',$input['borrower_id'])
                            ->where('notes',$input['receipt'])->where('other_income_type_id',$otherIncome['prodId'])
                            ->first())){

                            //get asset account
                            $accountTo = ChartOfAccount::where('name','Family Bank Account')->first();
                            $other_income = new OtherIncome();
                            $other_income->user_id = 2;
                            $other_income->other_income_type_id = $otherIncomeType->id;
                            $other_income->account_id = (!is_null($accountTo)? $accountTo->id: null);
                            $other_income->amount = $amount;
                            $other_income->notes = $input['receipt'];
                            $other_income->date = $input['date'];
                            $other_income->year = $input['year'];
                            $other_income->month = $input['month'];
                            $files = array();
                            $other_income->files = serialize($files);
                            $other_income->borrower_id = $input['borrower_id'];
                            $other_income->vehicle_id = $input['vehicle_id'];
                            $other_income->branch_id = 1;

                            $other_income->save();

                            $other_income = OtherIncome::find($other_income->id);
//            print_r($other_income->toArray());die;
                            //debit and credit the necessary accounts
                            if (!empty($other_income->chart)) {
                                $journal = new JournalEntry();
                                $journal->user_id = 2;
                                $journal->account_id = $other_income->chart->id;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->transaction_type = 'income';
                                $journal->name = "Other Income";
                                $journal->other_income_id = $other_income->id;
                                $journal->debit = $amount;
                                $journal->reference = $other_income->id;
                                $journal->notes = $input['receipt'];
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->borrower_id = $input['borrower_id'];
                                $journal->branch_id = session('branch_id') ?? 1;

                                $journal->save();
                            }
                            if (!empty($other_income->other_income_type->chart)) {
                                $journal = new JournalEntry();
                                $journal->user_id = 2;
                                $journal->account_id = $other_income->other_income_type->chart->id;
                                $journal->date = $input['date'];
                                $journal->year = $input['year'];
                                $journal->month = $input['month'];
                                $journal->transaction_type = 'income';
                                $journal->name = "Other Income";
                                $journal->other_income_id = $other_income->id;
                                $journal->credit = $amount;
                                $journal->reference = $other_income->id;
                                $journal->vehicle_id = $input['vehicle_id'];
                                $journal->notes = $input['receipt'];
                                $journal->borrower_id = $input['borrower_id'];
                                $journal->branch_id = session('branch_id') ?? 1;
                                $journal->save();
                            } else {
                                //alert admin that no account has been set
                            }
//                            GeneralHelper::audit_trail("Added other income with id:" . $other_income->id);

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
                    $input['date'] = Carbon::createFromFormat('d/m/Y H:i',$row['timestamp']) ;
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
                            'user_id' => 2,
                        ]);

                    }

                }
            }
        }

    }
}

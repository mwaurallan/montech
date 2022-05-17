<?php

namespace App\Http\Controllers;

use App\DataTables\MpesaPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMpesaPaymentRequest;
use App\Http\Requests\UpdateMpesaPaymentRequest;
use App\Models\Borrower;
use App\Models\JournalEntry;
use App\Models\MpesaPayment;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingTransaction;
use App\Repositories\MpesaPaymentRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Response;

class MpesaPaymentController extends AppBaseController
{
    /** @var  MpesaPaymentRepository */
    private $mpesaPaymentRepository;

    public function __construct(MpesaPaymentRepository $mpesaPaymentRepo)
    {
        $this->middleware('sentinel');
        $this->mpesaPaymentRepository = $mpesaPaymentRepo;
    }

    /**
     * Display a listing of the MpesaPayment.
     *
     * @param MpesaPaymentDataTable $mpesaPaymentDataTable
     * @return Response
     */
    public function index(MpesaPaymentDataTable $mpesaPaymentDataTable)
    {
        return $mpesaPaymentDataTable->render('mpesa_payments.index',[
            'members' => Borrower::all()
        ]);
    }

    /**
     * Show the form for creating a new MpesaPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('mpesa_payments.create');
    }

    /**
     * Store a newly created MpesaPayment in storage.
     *
     * @param CreateMpesaPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateMpesaPaymentRequest $request)
    {
        $input = $request->all();

        $mpesaPayment = $this->mpesaPaymentRepository->create($input);

        Flash::success('Mpesa Payment saved successfully.');

        return redirect(route('mpesaPayments.index'));
    }

    /**
     * Display the specified MpesaPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mpesaPayment = $this->mpesaPaymentRepository->find($id);

        if (empty($mpesaPayment)) {
            Flash::error('Mpesa Payment not found');

            return redirect(route('mpesaPayments.index'));
        }

        return view('mpesa_payments.show')->with('mpesaPayment', $mpesaPayment);
    }

    /**
     * Show the form for editing the specified MpesaPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mpesaPayment = $this->mpesaPaymentRepository->find($id);

        if (empty($mpesaPayment)) {
            Flash::error('Mpesa Payment not found');

            return redirect(route('mpesaPayments.index'));
        }

        return view('mpesa_payments.edit')->with('mpesaPayment', $mpesaPayment);
    }

    /**
     * Update the specified MpesaPayment in storage.
     *
     * @param  int              $id
     * @param UpdateMpesaPaymentRequest $request
     *
     * @return Response
     */
    public function update(\Illuminate\Http\Request $request)
    {
//        die;
//        print_r($request->all());die;
        $mpesaPayment = $this->mpesaPaymentRepository->find($request->payment_id);

        if (empty($mpesaPayment)) {
            Flash::error('Mpesa Payment not found');

            return redirect(route('mpesaPayments.index'));
        }
        DB::transaction(function()use ($request){
//            $mpesaPayment = $this->mpesaPaymentRepository->update($request->all(), $request->payment_id);
            $mpesaPayment = MpesaPayment::find($request->payment_id);
            $mpesaPayment->borrower_id = $request->borrower_id;
            $mpesaPayment->save();

            $this->processPayment($mpesaPayment);
        });


        Flash::success('Mpesa Payment updated successfully.');

        return redirect(route('mpesaPayments.index'));
    }

    public function processPayment(MpesaPayment $payment){
        if(!is_null($payment->borrower_id)){
            $input['date'] = $payment->received_on;
            $input['time'] = Carbon::parse($input['date'])->toTimeString();
            $input['year'] = Carbon::parse($input['date'])->year;
            $input['month'] = Carbon::parse($input['date'])->month;

            $savingProduct = SavingProduct::where('name','Savings')->first();
            $savingAccount = Saving::where('borrower_id',$payment->borrower_id)
                ->where('savings_product_id',$savingPId = $savingProduct->id ?? 1)
                ->first();
            if(is_null($savingAccount)){
                $savingAccount = Saving::create([
                    'user_id' => 1,
                    'borrower_id' => $payment->borrower_id,
                    'savings_product_id' => $savingPId,
                    'date' => $input['date'],
                    'status' => 'active',
                    'year' => $input['year'],
                    'month' => $input['month'],
                    'approved_date' => $input['date'],
                    'sacco_id' => 1,
                    'branch_id' => 1
                ]);
            }


//                    $this->_total += $saving['total'];
            $savings_transaction = new SavingTransaction();

            $savings_transaction->user_id = 1;
            $savings_transaction->borrower_id = $payment->borrower_id;
            $savings_transaction->branch_id = 1;
            $savings_transaction->receipt = $payment->ref_number;
            $savings_transaction->amount = $payment->amount;
            $savings_transaction->credit = $payment->amount;
            $savings_transaction->payment_method_id = 'MPESA';
            $savings_transaction->savings_id = $savingAccount->id;
            $savings_transaction->type = 'deposit';
            $savings_transaction->sacco_id = 1;

            $savings_transaction->reversible = 1;
            $savings_transaction->date = $input['date'];
            $savings_transaction->time = $input['time'];
            $date = explode('-', $input['date']);
            $savings_transaction->year = $input['year'];
            $savings_transaction->month = $input['month'];
            $savings_transaction->notes = "";
            $savings_transaction->save();

            $amount = $payment->amount;
            $input['type'] = "deposit";
            //make journal transactions
            if ($input['type'] == "deposit") {
                if (!empty($savingAccount->savings_product->chart_reference)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $savingAccount->savings_product->chart_reference->id;
                    $journal->branch_id = $savings_transaction->branch_id;
                    $journal->sacco_id = $savings_transaction->sacco_id;
                    $journal->date = $input['date'];
                    $journal->year = $input['year'];
                    $journal->month = $input['month'];
                    $journal->borrower_id = $savings_transaction->borrower_id;
                    $journal->transaction_type = 'deposit';
                    $journal->name = "Deposit";
                    $journal->savings_id = $savingAccount->id;
                    $journal->debit = $amount;
                    $journal->reference = $savings_transaction->id;
                    $journal->save();
                }
                if (!empty($savingAccount->savings_product->chart_control)) {
                    $journal = new JournalEntry();
                    $journal->user_id = 1;
                    $journal->account_id = $savingAccount->savings_product->chart_control->id;
                    $journal->branch_id = $savings_transaction->branch_id;
                    $journal->sacco_id = $savings_transaction->sacco_id;
                    $journal->date = $input['date'];
                    $journal->year = $input['year'];
                    $journal->month = $input['month'];
                    $journal->borrower_id = $payment->borrower_id;
                    $journal->transaction_type = 'deposit';
                    $journal->name = "Deposit";
                    $journal->savings_id = $savingAccount->id;
                    $journal->credit = $amount;
                    $journal->reference = $savings_transaction->id;
                    $journal->save();
                }
            }

            $payment->status = true;
            $payment->save();

        }
    }

    /**
     * Remove the specified MpesaPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mpesaPayment = $this->mpesaPaymentRepository->find($id);

        if (empty($mpesaPayment)) {
            Flash::error('Mpesa Payment not found');

            return redirect(route('mpesaPayments.index'));
        }

        $this->mpesaPaymentRepository->delete($id);

        Flash::success('Mpesa Payment deleted successfully.');

        return redirect(route('mpesaPayments.index'));
    }
}

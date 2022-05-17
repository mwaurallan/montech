<?php

namespace App\Http\Controllers;

use App\DataTables\InvoicePaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateInvoicePaymentRequest;
use App\Http\Requests\UpdateInvoicePaymentRequest;
use App\Models\ClientAccount;
use App\Models\CustomerAccount;
use App\Models\Invoice;
use App\Repositories\InvoicePaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

class InvoicePaymentController extends AppBaseController
{
    /** @var  InvoicePaymentRepository */
    private $invoicePaymentRepository;

    public function __construct(InvoicePaymentRepository $invoicePaymentRepo)
    {
        $this->invoicePaymentRepository = $invoicePaymentRepo;
        $this->middleware('sentinel');
    }

    /**
     * Display a listing of the InvoicePayment.
     *
     * @param InvoicePaymentDataTable $invoicePaymentDataTable
     * @return Response
     */
    public function index(InvoicePaymentDataTable $invoicePaymentDataTable)
    {
        return $invoicePaymentDataTable->render('invoice_payments.index');
    }

    /**
     * Show the form for creating a new InvoicePayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('invoice_payments.create');
    }

    /**
     * Store a newly created InvoicePayment in storage.
     *
     * @param CreateInvoicePaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateInvoicePaymentRequest $request)
    {
        $input = $request->all();

        DB::transaction(function ()use ($input){
            $invoicePayment = $this->invoicePaymentRepository->create($input);
            $customerAcc = CustomerAccount::create([
                'transaction_type' => 'DEBIT',
                'amount' => $invoicePayment->amount,
                'payment_id' => $invoicePayment->id
            ]);

            $accounts = CustomerAccount::all();
            $payments = $accounts->where('transaction_type',"DEBIT")->sum('amount');

            $invoices = Invoice::orderBy('invoice_date')->get();

            if(count($invoices)){
                foreach ($invoices as $invoice){
                    if( $payments > 0 && $invoice->amount <= $payments){
                        $invoice->status = true;
                        $payments = $payments - $invoice->amount;
                        $invoice->save();
                    }else{
                        continue;
                    }
                }
            }
        });

        Flash::success('Invoice Payment saved successfully.');

        return redirect(route('invoicePayments.index'));
    }

    /**
     * Display the specified InvoicePayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invoicePayment = $this->invoicePaymentRepository->find($id);

        if (empty($invoicePayment)) {
            Flash::error('Invoice Payment not found');

            return redirect(route('invoicePayments.index'));
        }

        return view('invoice_payments.show')->with('invoicePayment', $invoicePayment);
    }

    /**
     * Show the form for editing the specified InvoicePayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invoicePayment = $this->invoicePaymentRepository->find($id);

        if (empty($invoicePayment)) {
            Flash::error('Invoice Payment not found');

            return redirect(route('invoicePayments.index'));
        }

        return view('invoice_payments.edit')->with('invoicePayment', $invoicePayment);
    }

    /**
     * Update the specified InvoicePayment in storage.
     *
     * @param  int              $id
     * @param UpdateInvoicePaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInvoicePaymentRequest $request)
    {
        $invoicePayment = $this->invoicePaymentRepository->find($id);

        if (empty($invoicePayment)) {
            Flash::error('Invoice Payment not found');

            return redirect(route('invoicePayments.index'));
        }

        $invoicePayment = $this->invoicePaymentRepository->update($request->all(), $id);

        Flash::success('Invoice Payment updated successfully.');

        return redirect(route('invoicePayments.index'));
    }

    /**
     * Remove the specified InvoicePayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invoicePayment = $this->invoicePaymentRepository->find($id);

        if (empty($invoicePayment)) {
            Flash::error('Invoice Payment not found');

            return redirect(route('invoicePayments.index'));
        }

        $this->invoicePaymentRepository->delete($id);

        Flash::success('Invoice Payment deleted successfully.');

        return redirect(route('invoicePayments.index'));
    }
}

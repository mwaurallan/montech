<?php

namespace App\Http\Controllers;

use App\DataTables\ProcessedMpesaPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProcessedMpesaPaymentRequest;
use App\Http\Requests\UpdateProcessedMpesaPaymentRequest;
use App\Repositories\ProcessedMpesaPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ProcessedMpesaPaymentController extends AppBaseController
{
    /** @var  ProcessedMpesaPaymentRepository */
    private $processedMpesaPaymentRepository;

    public function __construct(ProcessedMpesaPaymentRepository $processedMpesaPaymentRepo)
    {
        $this->processedMpesaPaymentRepository = $processedMpesaPaymentRepo;
        $this->middleware('sentinel');
    }

    /**
     * Display a listing of the ProcessedMpesaPayment.
     *
     * @param ProcessedMpesaPaymentDataTable $processedMpesaPaymentDataTable
     * @return Response
     */
    public function index(ProcessedMpesaPaymentDataTable $processedMpesaPaymentDataTable)
    {
        return $processedMpesaPaymentDataTable->render('processed_mpesa_payments.index');
    }

    /**
     * Show the form for creating a new ProcessedMpesaPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('processed_mpesa_payments.create');
    }

    /**
     * Store a newly created ProcessedMpesaPayment in storage.
     *
     * @param CreateProcessedMpesaPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateProcessedMpesaPaymentRequest $request)
    {
        $input = $request->all();

        $processedMpesaPayment = $this->processedMpesaPaymentRepository->create($input);

        Flash::success('Processed Mpesa Payment saved successfully.');

        return redirect(route('processedMpesaPayments.index'));
    }

    /**
     * Display the specified ProcessedMpesaPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $processedMpesaPayment = $this->processedMpesaPaymentRepository->find($id);

        if (empty($processedMpesaPayment)) {
            Flash::error('Processed Mpesa Payment not found');

            return redirect(route('processedMpesaPayments.index'));
        }

        return view('processed_mpesa_payments.show')->with('processedMpesaPayment', $processedMpesaPayment);
    }

    /**
     * Show the form for editing the specified ProcessedMpesaPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $processedMpesaPayment = $this->processedMpesaPaymentRepository->find($id);

        if (empty($processedMpesaPayment)) {
            Flash::error('Processed Mpesa Payment not found');

            return redirect(route('processedMpesaPayments.index'));
        }

        return view('processed_mpesa_payments.edit')->with('processedMpesaPayment', $processedMpesaPayment);
    }

    /**
     * Update the specified ProcessedMpesaPayment in storage.
     *
     * @param  int              $id
     * @param UpdateProcessedMpesaPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcessedMpesaPaymentRequest $request)
    {
        $processedMpesaPayment = $this->processedMpesaPaymentRepository->find($id);

        if (empty($processedMpesaPayment)) {
            Flash::error('Processed Mpesa Payment not found');

            return redirect(route('processedMpesaPayments.index'));
        }

        $processedMpesaPayment = $this->processedMpesaPaymentRepository->update($request->all(), $id);

        Flash::success('Processed Mpesa Payment updated successfully.');

        return redirect(route('processedMpesaPayments.index'));
    }

    /**
     * Remove the specified ProcessedMpesaPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $processedMpesaPayment = $this->processedMpesaPaymentRepository->find($id);

        if (empty($processedMpesaPayment)) {
            Flash::error('Processed Mpesa Payment not found');

            return redirect(route('processedMpesaPayments.index'));
        }

        $this->processedMpesaPaymentRepository->delete($id);

        Flash::success('Processed Mpesa Payment deleted successfully.');

        return redirect(route('processedMpesaPayments.index'));
    }
}

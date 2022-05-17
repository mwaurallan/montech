<?php

namespace App\Http\Controllers;

use App\DataTables\TripPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTripPaymentRequest;
use App\Http\Requests\UpdateTripPaymentRequest;
use App\Repositories\TripPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TripPaymentController extends AppBaseController
{
    /** @var  TripPaymentRepository */
    private $tripPaymentRepository;

    public function __construct(TripPaymentRepository $tripPaymentRepo)
    {
        $this->tripPaymentRepository = $tripPaymentRepo;
    }

    /**
     * Display a listing of the TripPayment.
     *
     * @param TripPaymentDataTable $tripPaymentDataTable
     * @return Response
     */
    public function index(TripPaymentDataTable $tripPaymentDataTable)
    {
        return $tripPaymentDataTable->render('trip_payments.index');
    }

    /**
     * Show the form for creating a new TripPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('trip_payments.create');
    }

    /**
     * Store a newly created TripPayment in storage.
     *
     * @param CreateTripPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateTripPaymentRequest $request)
    {
        $input = $request->all();

        $tripPayment = $this->tripPaymentRepository->create($input);

        Flash::success('Trip Payment saved successfully.');

        return redirect(route('tripPayments.index'));
    }

    /**
     * Display the specified TripPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tripPayment = $this->tripPaymentRepository->find($id);

        if (empty($tripPayment)) {
            Flash::error('Trip Payment not found');

            return redirect(route('tripPayments.index'));
        }

        return view('trip_payments.show')->with('tripPayment', $tripPayment);
    }

    /**
     * Show the form for editing the specified TripPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tripPayment = $this->tripPaymentRepository->find($id);

        if (empty($tripPayment)) {
            Flash::error('Trip Payment not found');

            return redirect(route('tripPayments.index'));
        }

        return view('trip_payments.edit')->with('tripPayment', $tripPayment);
    }

    /**
     * Update the specified TripPayment in storage.
     *
     * @param  int              $id
     * @param UpdateTripPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTripPaymentRequest $request)
    {
        $tripPayment = $this->tripPaymentRepository->find($id);

        if (empty($tripPayment)) {
            Flash::error('Trip Payment not found');

            return redirect(route('tripPayments.index'));
        }

        $tripPayment = $this->tripPaymentRepository->update($request->all(), $id);

        Flash::success('Trip Payment updated successfully.');

        return redirect(route('tripPayments.index'));
    }

    /**
     * Remove the specified TripPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tripPayment = $this->tripPaymentRepository->find($id);

        if (empty($tripPayment)) {
            Flash::error('Trip Payment not found');

            return redirect(route('tripPayments.index'));
        }

        $this->tripPaymentRepository->delete($id);

        Flash::success('Trip Payment deleted successfully.');

        return redirect(route('tripPayments.index'));
    }
}

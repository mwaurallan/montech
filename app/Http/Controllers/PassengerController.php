<?php

namespace App\Http\Controllers;

use App\DataTables\PassengerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePassengerRequest;
use App\Http\Requests\UpdatePassengerRequest;
use App\Repositories\PassengerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PassengerController extends AppBaseController
{
    /** @var  PassengerRepository */
    private $passengerRepository;

    public function __construct(PassengerRepository $passengerRepo)
    {
        $this->passengerRepository = $passengerRepo;
    }

    /**
     * Display a listing of the Passenger.
     *
     * @param PassengerDataTable $passengerDataTable
     * @return Response
     */
    public function index(PassengerDataTable $passengerDataTable)
    {
        return $passengerDataTable->render('passengers.index');
    }

    /**
     * Show the form for creating a new Passenger.
     *
     * @return Response
     */
    public function create()
    {
        return view('passengers.create');
    }

    /**
     * Store a newly created Passenger in storage.
     *
     * @param CreatePassengerRequest $request
     *
     * @return Response
     */
    public function store(CreatePassengerRequest $request)
    {
        $input = $request->all();

        $passenger = $this->passengerRepository->create($input);

        Flash::success('Passenger saved successfully.');

        return redirect(route('passengers.index'));
    }

    /**
     * Display the specified Passenger.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passenger = $this->passengerRepository->find($id);

        if (empty($passenger)) {
            Flash::error('Passenger not found');

            return redirect(route('passengers.index'));
        }

        return view('passengers.show')->with('passenger', $passenger);
    }

    /**
     * Show the form for editing the specified Passenger.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passenger = $this->passengerRepository->find($id);

        if (empty($passenger)) {
            Flash::error('Passenger not found');

            return redirect(route('passengers.index'));
        }

        return view('passengers.edit')->with('passenger', $passenger);
    }

    /**
     * Update the specified Passenger in storage.
     *
     * @param  int              $id
     * @param UpdatePassengerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePassengerRequest $request)
    {
        $passenger = $this->passengerRepository->find($id);

        if (empty($passenger)) {
            Flash::error('Passenger not found');

            return redirect(route('passengers.index'));
        }

        $passenger = $this->passengerRepository->update($request->all(), $id);

        Flash::success('Passenger updated successfully.');

        return redirect(route('passengers.index'));
    }

    /**
     * Remove the specified Passenger from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passenger = $this->passengerRepository->find($id);

        if (empty($passenger)) {
            Flash::error('Passenger not found');

            return redirect(route('passengers.index'));
        }

        $this->passengerRepository->delete($id);

        Flash::success('Passenger deleted successfully.');

        return redirect(route('passengers.index'));
    }
}

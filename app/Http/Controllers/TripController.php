<?php

namespace App\Http\Controllers;

use App\DataTables\TripDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\MemberVehicle;
use App\Repositories\TripRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ixudra\Curl\Facades\Curl;
use Response;

class TripController extends AppBaseController
{
    /** @var  TripRepository */
    private $tripRepository;

    public function __construct(TripRepository $tripRepo)
    {
        $this->tripRepository = $tripRepo;
        $this->middleware('sentinel');
    }

    /**
     * Display a listing of the Trip.
     *
     * @param TripDataTable $tripDataTable
     * @return Response
     */
    public function index(TripDataTable $tripDataTable)
    {

        return $tripDataTable->render('trips.index');
    }

    /**
     * Show the form for creating a new Trip.
     *
     * @return Response
     */
    public function create()
    {
        $vehicles = MemberVehicle::where('status',true)->with('vehicle')->get();
        return view('trips.create',[
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Store a newly created Trip in storage.
     *
     * @param CreateTripRequest $request
     *
     * @return Response
     */
    public function store(CreateTripRequest $request)
    {
        $input = $request->all();

        $messages = [
            'member_vehicle_id.unique' => 'There is an active trip for this vehicle! You must end it to start a new trip.',
        ];

        $rules = [
            'member_vehicle_id' =>
                Rule::unique('trips')->where(function($q)use($request){
                    return $q->where('status',true)->where('deleted_at');
                })
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $trip = $this->tripRepository->create($input);

        //save trip to payment gateway
        $url = 'https://payments.openpathsolutions.co.ke/api/addVehicle';
//        $url = 'http://localhost/payments/public/api/addVehicle';
        //once a trip has been created go to payments gateway and create and invoice as an
        $vehicleRegistration = MemberVehicle::where('id',$trip->member_vehicle_id)->with('vehicle')->first()->vehicle->vehicle;
        $message = Curl::to($url)
            ->withData([
                'vehicle' => $vehicleRegistration,
                'source' => $request->getSchemeAndHttpHost()
            ])
            ->returnResponseObject()
            ->post();
        Log::info($message->content);

        Flash::success('Trip created successfully.');

        return redirect(route('trips.index'));
    }

    /**
     * Display the specified Trip.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $trip = $this->tripRepository->find($id);

        if (empty($trip)) {
            Flash::error('Trip not found');

            return redirect(route('trips.index'));
        }

        return view('trips.show')->with('trip', $trip);
    }

    /**
     * Show the form for editing the specified Trip.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $trip = $this->tripRepository->find($id);

        if (empty($trip)) {
            Flash::error('Trip not found');

            return redirect(route('trips.index'));
        }

        return view('trips.edit',[
            'vehicles' => MemberVehicle::where('status',true)->with('vehicle')->get()
        ])
            ->with('trip', $trip);
    }

    /**
     * Update the specified Trip in storage.
     *
     * @param  int              $id
     * @param UpdateTripRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTripRequest $request)
    {
        $trip = $this->tripRepository->find($id);

        if (empty($trip)) {
            Flash::error('Trip not found');

            return redirect(route('trips.index'));
        }

        $trip = $this->tripRepository->update($request->all(), $id);

        Flash::success('Trip updated successfully.');

        return redirect(route('trips.index'));
    }

    /**
     * Remove the specified Trip from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $trip = $this->tripRepository->find($id);

        if (empty($trip)) {
            Flash::error('Trip not found');

            return redirect(route('trips.index'));
        }

        $this->tripRepository->delete($id);

        Flash::success('Trip deleted successfully.');

        return redirect(route('trips.index'));
    }
}

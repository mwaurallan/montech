<?php

namespace App\Http\Controllers;

use App\DataTables\MemberVehicleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMemberVehicleRequest;
use App\Http\Requests\UpdateMemberVehicleRequest;
use App\Models\Borrower;
use App\Models\MemberVehicle;
use App\Models\Saving;
use App\Models\Vehicle;
use App\Repositories\MemberVehicleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;
use Sabberworm\CSS\Rule\Rule;

class MemberVehicleController extends AppBaseController
{
    /** @var  MemberVehicleRepository */
    private $memberVehicleRepository;

    public function __construct(MemberVehicleRepository $memberVehicleRepo)
    {
        $this->middleware('sentinel');
        $this->memberVehicleRepository = $memberVehicleRepo;
    }

    /**
     * Display a listing of the MemberVehicle.
     *
     * @param MemberVehicleDataTable $memberVehicleDataTable
     * @return Response
     */
    public function index(MemberVehicleDataTable $memberVehicleDataTable)
    {
        return $memberVehicleDataTable->render('member_vehicles.index');
    }

    /**
     * Show the form for creating a new MemberVehicle.
     *
     * @return Response
     */
    public function create()
    {
        return view('member_vehicles.create',[
            'members' => Borrower::all(),
            'vehicles' => Vehicle::all()
        ]);
    }

    /**
     * Store a newly created MemberVehicle in storage.
     *
     * @param CreateMemberVehicleRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'member_id' => 'required',
            'vehicle_id' => \Illuminate\Validation\Rule::unique('member_vehicles')->where(function($query)use($request){
                return $query->where('status', 1)->where('vehicle_id',$request->vehicle_id);
            })
        ]);
        $input = $request->all();

        $memberVehicle = $this->memberVehicleRepository->create($input);

        Flash::success('Member Vehicle saved successfully.');

        return redirect(route('memberVehicles.index'));
    }

    /**
     * Display the specified MemberVehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $memberVehicle = $this->memberVehicleRepository->find($id);

        if (empty($memberVehicle)) {
            Flash::error('Member Vehicle not found');

            return redirect(route('memberVehicles.index'));
        }

        return view('member_vehicles.show')->with('memberVehicle', $memberVehicle);
    }

    /**
     * Show the form for editing the specified MemberVehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $memberVehicle = $this->memberVehicleRepository->find($id);

        if (empty($memberVehicle)) {
            Flash::error('Member Vehicle not found');

            return redirect(route('memberVehicles.index'));
        }

        return view('member_vehicles.edit',[
            'members' => Borrower::all(),
            'vehicles' => Vehicle::all()
        ])->with('memberVehicle', $memberVehicle);
    }

    /**
     * Update the specified MemberVehicle in storage.
     *
     * @param  int              $id
     * @param UpdateMemberVehicleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMemberVehicleRequest $request)
    {
        $memberVehicle = $this->memberVehicleRepository->find($id);

        if (empty($memberVehicle)) {
            Flash::error('Member Vehicle not found');

            return redirect(route('memberVehicles.index'));
        }

        $memberVehicle = $this->memberVehicleRepository->update($request->all(), $id);

        Flash::success('Member Vehicle updated successfully.');

        return redirect(route('memberVehicles.index'));
    }

    /**
     * Remove the specified MemberVehicle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $memberVehicle = $this->memberVehicleRepository->find($id);

        if (empty($memberVehicle)) {
            Flash::error('Member Vehicle not found');

            return redirect(route('memberVehicles.index'));
        }

        $this->memberVehicleRepository->delete($id);

        Flash::success('Member Vehicle deleted successfully.');

        return redirect(route('memberVehicles.index'));
    }

    public function getVehicles($id){
        $members = MemberVehicle::where('member_id',$id)->with('vehicle')->get();

        return response()->json($members);
    }
}

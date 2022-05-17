@extends('layouts.master')

@section('title')
    Member Vehicles
@endsection


@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Add Member Vehicles </h6>

            <div class="heading-elements">
                @if(Sentinel::hasAccess('memberVehicles.create'))
                    <a href="{{ url('borrower/memberVehicles/create') }}"
                       class="btn btn-info btn-sm"> Member Vehicles </a>
                @endif
            </div>
        </div>

        <div class="panel-body ">
                 <div class="table-responsive">
                    @include('member_vehicles.table')
                </div>
        </div>
    </div>
@endsection


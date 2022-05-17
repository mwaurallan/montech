@extends('layouts.master')

@section('title')
    Vehicles
@endsection


@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Vehicles </h6>

            <div class="heading-elements">
                @if(Sentinel::hasAccess('vehicles.create'))
                    <a href="{{ url('borrower/vehicles/create') }}"
                       class="btn btn-info btn-sm">Add Vehicles </a>
                @endif
            </div>
        </div>

        <div class="panel-body ">
                 <div class="table-responsive">
                    @include('vehicles.table')
                </div>
        </div>
    </div>
@endsection


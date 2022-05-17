@extends('layouts.master')

@section('title')
    Member Vehicles
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Member Vehicle
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('member_vehicles.show_fields')
                    <a href="{!! route('memberVehicles.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

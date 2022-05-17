@extends('layouts.master')

@section('title')
    Add Member Vehicle
@endsection

@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Edit Member Vehicle </h6>
            <div class="heading-elements">

            </div>
        </div>
           {!! Form::model($memberVehicle, ['route' => ['memberVehicles.update', $memberVehicle->id], 'method' => 'patch']) !!}
                <div class="panel-body">
{{--                    @include('member_vehicles.fields')--}}

<!-- Member Id Field -->
{{--    <div class="form-group col-sm-12">--}}
{{--        {!! Form::label('member_id', 'Member :') !!}--}}
{{--        <select name="member_id" class="form-control select2" required>--}}
{{--            <option value="">Select Member</option>--}}
{{--            @if(count($members))--}}
{{--                @foreach($members as $member)--}}
{{--                    <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </select>--}}
{{--    </div>--}}

{{--    <!-- Vehicle Id Field -->--}}
{{--    <div class="form-group col-sm-12">--}}
{{--        {!! Form::label('vehicle_id', 'Vehicle :') !!}--}}
{{--        <select name="vehicle_id" class="form-control select2" required>--}}
{{--            <option value="">Select Vehicle</option>--}}
{{--            @if(count($vehicles))--}}
{{--                @foreach($vehicles as $vehicle)--}}
{{--                    <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle }} </option>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </select>--}}
{{--    </div>--}}

    <!-- Status Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('status', 'Status:') !!}
        <select name="status" class="form-control">
            <option value="1">Active</option>
            <option value="0">InActive</option>
        </select>
    </div>



                </div>
                 <div class="panel-footer">
                 <div class="heading-elements">
                     <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
                     <a href="{!! route('memberVehicles.index') !!}" class="btn btn-danger pull-left" style="margin-left: 10px;">Cancel</a>
                 </div>
                  </div>
            {!! Form::close() !!}
    </div>
@endsection

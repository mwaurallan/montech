@extends('layouts.master')

@section('title')
    Add Vehicle
@endsection

@section('content')
    <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Add Vehicle </h6>
                <div class="heading-elements">

                </div>
            </div>

            {!! Form::open(['route' => 'vehicles.store']) !!}
                 <div class="panel-body">
                    @include('vehicles.fields')
                 </div>
                 <div class="panel-footer">
                     <div class="heading-elements">
                         <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                         <a href="{!! route('vehicles.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                     </div>
                  </div>
            {!! Form::close() !!}
    </div>
@endsection

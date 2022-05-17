@extends('layouts.master')

@section('title')
    Edit Passenger
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Passenger </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                   {!! Form::model($passenger, ['route' => ['passengers.update', $passenger->id], 'method' => 'patch']) !!}

                     <div class="panel-body">
                         @include('passengers.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('passengers.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

@extends('layouts.master')

@section('title')
    Edit Trip
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Trip </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                     {!! Form::model($trip, ['route' => ['trips.update', $trip->id], 'method' => 'patch']) !!}
                     <div class="panel-body">
                         @include('trips.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('trips.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

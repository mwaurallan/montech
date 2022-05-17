@extends('layouts.master')
@section('title')
    View Passenger
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Passenger </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('passengers.show_fields')
              <a href="{{ route('passengers.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection


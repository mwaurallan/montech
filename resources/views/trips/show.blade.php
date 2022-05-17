@extends('layouts.master')

@section('title')
    View Trip
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Trip </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('trips.show_fields')
              <a href="{{ route('trips.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection

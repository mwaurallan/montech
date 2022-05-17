@extends('layouts.master')

@section('title')
    Show Trip Payment
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Trip Payment </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('trip_payments.show_fields')
              <a href="{{ route('tripPayments.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection

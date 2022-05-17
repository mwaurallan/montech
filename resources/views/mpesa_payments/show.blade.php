@extends('layouts.master')
@section('title')
    View Mpesa Payment
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Mpesa Payment </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('mpesa_payments.show_fields')
              <a href="{{ route('mpesaPayments.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection


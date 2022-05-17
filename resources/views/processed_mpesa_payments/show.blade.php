@extends('layouts.master')
@section('title')
    View Processed Mpesa Payment
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Processed Mpesa Payment </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('processed_mpesa_payments.show_fields')
              <a href="{{ route('processedMpesaPayments.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection


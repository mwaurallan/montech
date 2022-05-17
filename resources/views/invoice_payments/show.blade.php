@extends('layouts.master')
@section('title')
    View Invoice Payment
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Invoice Payment </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('invoice_payments.show_fields')
              <a href="{{ route('invoicePayments.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection


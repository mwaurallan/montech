@extends('layouts.master')
@section('title')
Processed Mpesa Payments
@endsection
@section('content')
<div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Processed Mpesa Payments</h6>
            <div class="heading-elements">
                @if(Sentinel::hasAccess('processedMpesaPayments.create'))
                    <a href="{{ route('processedMpesaPayments.create') }}"
                       class="btn btn-info btn-sm">Add New</a>
                @endif
            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                @include('processed_mpesa_payments.table')
            </div>
        </div>
        <!-- /.panel-body -->
</div>
@endsection


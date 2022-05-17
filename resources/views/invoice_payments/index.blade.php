@extends('layouts.master')
@section('title')
Invoice Payments
@endsection
@section('content')
<div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Invoice Payments</h6>
            <div class="heading-elements">
                @if(Sentinel::hasAccess('invoicePayments.create'))
                    <a href="{{ route('invoicePayments.create') }}"
                       class="btn btn-info btn-sm">Add New</a>
                @endif
            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                @include('invoice_payments.table')
            </div>
        </div>
        <!-- /.panel-body -->
</div>
@endsection


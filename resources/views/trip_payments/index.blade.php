@extends('layouts.master')
@section('title')
    Trip Payments
@endsection
@section('content')
    <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Trip Payments</h6>
                <div class="heading-elements">
                    @if(Sentinel::hasAccess('tripPayments.create'))
                        <a href="{{ route('tripPayments.create') }}"
                           class="btn btn-info btn-sm">Add New</a>
                    @endif
                </div>
            </div>
            <div class="panel-body ">
                <div class="table-responsive">
                    @include('trip_payments.table')
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
@endsection


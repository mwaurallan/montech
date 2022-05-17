@extends('layouts.master')
@section('title')
Payments
@endsection
@section('content')
<div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Payments</h6>
            <div class="heading-elements">
                @if(Sentinel::hasAccess('payments.create'))
                    <a href="{{ route('payments.create') }}"
                       class="btn btn-info btn-sm">Add New</a>
                @endif
            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                @include('payments.table')
            </div>
        </div>
        <!-- /.panel-body -->
</div>
@endsection


@extends('layouts.master')
@section('title')
Invoices
@endsection
@section('content')
<div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Invoices</h6>
            <div class="heading-elements">
                @if(Sentinel::hasAccess('invoices.create'))
                    <a href="{{ route('invoices.create') }}"
                       class="btn btn-info btn-sm">Add New</a>
                @endif
            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                @include('invoices.table')
            </div>
        </div>
        <!-- /.panel-body -->
</div>
@endsection


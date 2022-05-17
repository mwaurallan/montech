@extends('layouts.master')

@section('title')
    Field Saving Transactions
@endsection


@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Field Saving Transactions </h6>

{{--            <div class="heading-elements">--}}
                @if(Sentinel::hasAccess('fieldSavingTransactions.create'))
                    <a href="{{ url('saving/fieldSavingTransactions/create') }}"
                       class="btn btn-info btn-sm"> Add Transactions </a>
                @endif
{{--            </div>--}}
        </div>

        <div class="panel-body ">
                 <div class="table-responsive">
                    @include('field_saving_transactions.table')
                </div>
        </div>
    </div>
@endsection







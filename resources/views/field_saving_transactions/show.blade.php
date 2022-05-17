@extends('layouts.master')

@section('title')
    Field Saving Transactions
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Field Saving Transaction
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('field_saving_transactions.show_fields')
                    <a href="{!! route('fieldSavingTransactions.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

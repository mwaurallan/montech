@extends('layouts.master')

@section('title')
    Loan Repaymet Receipts
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Loan Repaymet Receipt
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('loan_repaymet_receipts.show_fields')
                    <a href="{!! route('loanRepaymetReceipts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

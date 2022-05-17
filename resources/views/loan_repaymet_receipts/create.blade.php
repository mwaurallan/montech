@extends('layouts.master')

@section('title')
    Add Loan Repaymet Receipt
@endsection

@section('content')
    <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Add Loan Repaymet Receipt </h6>
                <div class="heading-elements">

                </div>
            </div>

            {!! Form::open(['route' => 'loanRepaymetReceipts.store']) !!}
                 <div class="panel-body">
                    @include('loan_repaymet_receipts.fields')
                 </div>
                 <div class="panel-footer">
                     <div class="heading-elements">
                         <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}} </button>
                         <a href="{!! route('loanRepaymetReceipts.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                     </div>
                  </div>
            {!! Form::close() !!}
    </div>
@endsection

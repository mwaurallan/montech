@extends('layouts.master')

@section('title')
    Edit Invoice Payment
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Invoice Payment </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                   {!! Form::model($invoicePayment, ['route' => ['invoicePayments.update', $invoicePayment->id], 'method' => 'patch']) !!}

                     <div class="panel-body">
                         @include('invoice_payments.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('invoicePayments.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

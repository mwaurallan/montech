@extends('layouts.master')

@section('title')
    Edit Invoice
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Invoice </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                   {!! Form::model($invoice, ['route' => ['invoices.update', $invoice->id], 'method' => 'patch']) !!}

                     <div class="panel-body">
                         @include('invoices.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('invoices.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

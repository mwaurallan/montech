@extends('layouts.master')

@section('title')
    Edit Payment
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Payment </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                   {!! Form::model($payment, ['route' => ['payments.update', $payment->id], 'method' => 'patch']) !!}

                     <div class="panel-body">
                         @include('payments.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('payments.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

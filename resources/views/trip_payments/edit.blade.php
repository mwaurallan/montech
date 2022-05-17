@extends('layouts.master')

@section('title')
    Edit Trip Payment
@endsection
@section('content')
    <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title"> Edit Trip Payment </h6>
                    <div class="heading-elements">

                    </div>
                </div>
                @include('adminlte-templates::common.errors')
                     {!! Form::model($tripPayment, ['route' => ['tripPayments.update', $tripPayment->id], 'method' => 'patch']) !!}
                     <div class="panel-body">
                         @include('trip_payments.fields')
                     </div>
                     <div class="panel-footer">
                         <div class="heading-elements">
                             <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}}</button>
                             <a href="{!! route('tripPayments.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                         </div>
                      </div>
                {!! Form::close() !!}
        </div>
@endsection

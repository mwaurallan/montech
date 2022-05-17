@extends('layouts.master')

@section('title')
    Add Field Saving Transaction
@endsection

@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Edit Field Saving Transaction </h6>
            <div class="heading-elements">

            </div>
        </div>
           {!! Form::model($fieldSavingTransaction, ['route' => ['fieldSavingTransactions.update', $fieldSavingTransaction->id], 'method' => 'patch']) !!}
                <div class="panel-body">
                    @include('field_saving_transactions.fields')
                </div>
                 <div class="panel-footer">
                 <div class="heading-elements">
                     <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
                     <a href="{!! route('fieldSavingTransactions.index') !!}" class="btn btn-danger pull-left" style="margin-left: 10px;">Cancel</a>
                 </div>
                  </div>
            {!! Form::close() !!}
    </div>
@endsection

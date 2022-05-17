@extends('layouts.master')
@section('title')
    {{ trans_choice('general.add',1) }} {{ trans_choice('general.other_income',1) }} {{ trans_choice('general.type',1) }}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">{{ trans_choice('general.add',1) }} {{ trans_choice('general.other_income',1) }} {{ trans_choice('general.type',1) }}</h6>

            <div class="heading-elements">

            </div>
        </div>
        {!! Form::open(array('url' => url('other_income/type/store'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('name',trans_choice('general.name',1),array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('name',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('account_to','Account To Debit',array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('account_to',$account_to,null, array('class' => 'form-control select2','required'=>'required')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('account_id','Account To Credit',array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('account_id',$chart_income,null, array('class' => 'form-control select2','required'=>'required')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('appear_on_receipt','Appear On Receipt',array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <select name="appear_on_receipt" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="heading-elements">
                <button type="submit" class="btn btn-primary pull-right">{{ trans_choice('general.save',1) }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection


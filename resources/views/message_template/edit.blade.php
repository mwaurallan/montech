@extends('layouts.master')
@section('title')
    {{trans_choice('general.edit',1)}} Message Template
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">{{trans_choice('general.edit',1)}} Message Template</h6>

            <div class="heading-elements">

            </div>
        </div>
        {!! Form::open(array('url' => url('template/'.$charge->id.'/update'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('event',trans_choice('general.name',1)." *",array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('event',$charge->event, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('message','Message '." *",array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <textarea name="message" class="form-control" rows="3" required>{{$charge->message}}</textarea>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('status',trans_choice('general.active',1),array('class'=>'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('status',['1'=>trans_choice('general.yes',1),'0'=>trans_choice('general.no',2)],$charge->status, array('class' => 'form-control', 'id'=>"active",'required'=>'required')) !!}
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="heading-elements">
                <button type="submit" class="btn btn-primary pull-right"> {{trans_choice('general.save',1)}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection
@section('footer-scripts')
    <script>
        $(document).ready(function (e) {
            if ($('#product').val() === "loan") {
                $('#loanChargeTypeDiv').show();
                $('#loanChargeOptionDiv').show();
                $('#penaltyDiv').show();
                $('#overrideDiv').show();
                $('#savingsChargeTypeDiv').hide();
                $('#savingsChargeOptionDiv').hide();
            } else {
                $('#savingsChargeTypeDiv').show();
                $('#savingsChargeOptionDiv').show();
                $('#loanChargeTypeDiv').hide();
                $('#loanChargeOptionDiv').hide();
                $('#penaltyDiv').hide();
                $('#overrideDiv').hide();

            }
            $('#product').change(function () {
                if ($('#product').val() === "loan") {
                    $('#loanChargeTypeDiv').show();
                    $('#loanChargeOptionDiv').show();
                    $('#penaltyDiv').show();
                    $('#overrideDiv').show();
                    $('#savingsChargeTypeDiv').hide();
                    $('#savingsChargeOptionDiv').hide();
                } else {
                    $('#savingsChargeTypeDiv').show();
                    $('#savingsChargeOptionDiv').show();
                    $('#loanChargeTypeDiv').hide();
                    $('#loanChargeOptionDiv').hide();
                    $('#penaltyDiv').hide();
                    $('#overrideDiv').hide();

                }
            })
        })
    </script>
@endsection

@extends('layouts.master')
@section('title')
    Import Transactions
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Import Transactions</h6>
            <div class="heading-elements">

            </div>
        </div>
        {!! Form::open(array('url' => url('importTransactions'), 'method' => 'post', 'name' => 'form',"enctype"=>"multipart/form-data")) !!}
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" class="form-control-file" name="transactions_csv" required>
                    </div>
                    <div class="col-md-4">

                         </div>
                </div>
            </div>

            @if(isset($total))
                <div class="form-group">
                    <br>
                    <br>
                    <br>
                    <h3>TOtal: {{ $total }}</h3>

                </div>

                @endif

        </div>
        <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="heading-elements">
                <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection


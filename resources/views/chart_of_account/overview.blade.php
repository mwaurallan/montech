@extends('layouts.master')
@section('title')
    Accounts Overview
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Accounts Overview</h6>


        </div>
        <div class="panel-body ">
            <div class="row">
                @if(count($accounts))
                    @foreach($accounts as $account)
                        <div class="col-md-3">
                            <div class="panel @if($account['amount'] <= 0) panel-warning @else panel-success @endif">
                                <div class="panel-heading">
                                    <h5 class="panel-title">{{ $account['name'] }}</h5>
                                    <!-- /.panel-tools -->
                                </div>
                                <!-- /.panel-header -->
                                <div class="panel-body">
                                    <h4>KES {{ number_format($account['amount'],2) }} </h4>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    @endforeach
                    @endif
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.box -->
@endsection

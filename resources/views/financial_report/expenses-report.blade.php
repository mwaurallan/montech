@extends('layouts.master')
@section('title')
    Expenses Report
@endsection

@section('css')
    @include('report.includes.table-style')
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                Expenses Report
                @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
            </h6>

            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body hidden-print">
            <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                <div class="col-xs-4">
                    <select name="type" class="form-control select2">
                        <option value="all">All Expense Types</option>
                        @if(count($types))
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
                <div class="col-xs-3">
                    {!! Form::text('start_date',\Carbon\Carbon::today()->startOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-1  text-center" style="padding-top: 5px;">
                    to
                </div>
                <div class="col-xs-3">
                    {!! Form::text('end_date',\Carbon\Carbon::today()->endOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">

                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>



                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>
    <!-- /.box -->
    @if(count($expenses))
        <div class="panel panel-white">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                       <th>Date</th>
                       <th>Expense</th>
                       <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($expenses))
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($expense->date)->toDateString() }}</td>
                                    <td>{{ $expense->expense_type->name }}</td>
                                    <td>{{ number_format($expense->amount,2) }}</td>
                                </tr>
                                @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{ number_format($expenses->sum('amount'),2) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3" class="text-center">No records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
@section('footer-scripts')

@endsection

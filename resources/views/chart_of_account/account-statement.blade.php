@extends('layouts.master')
@section('title')
    Account Statement
@endsection

@section('css')
    @include('report.includes.table-style')
@endsection
@section('content')
    <div class="panel panel-white hidden-print">
        <div class="panel-heading">
            <h6 class="panel-title">
                Account Statement
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
                <div class="form-group col-md-4" style="margin-right: 3px">
                    <label>Account</label>
                    <select name="account" class="form-control select2" required>
                        @if(count($charts))
                            @foreach($charts as $chart)
                                <option value="{{ $chart->id }}">{{ $chart->name }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label>From</label>
                        {!! Form::text('start_date',\Carbon\Carbon::today()->startOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label>To</label>
                        {!! Form::text('end_date',\Carbon\Carbon::today()->endOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                    </div>
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
    @if(isset($transactions))
        <div class="panel panel-white">
            <div class="panel-body table-responsive ">

                <div class="row">
                <table class="table table-bordered table-condensed table-hover">

                        <thead>
                        <tr class="bg-green">
                            <th>Date</th>
                            <th>Name</th>
                            <th>Reference</th>
                            <th>Notes</th>
                            <th>Transaction Type</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Running Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="7">Balance B/F</td>
                            <td>{{ number_format($bf) }}</td>
                        </tr>
                        @if(count($transactions))
                            @foreach($transactions as $transaction)
                                @if($transaction->debit > 0)
                                    @php $bf = $bf + $transaction->debit @endphp
                                    @elseif($transaction->credit > 0)
                                    @php $bf = $bf - $transaction->credit @endphp
                                    @endif
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date)->toDateString() }}</td>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->reference }}</td>
                                    <td>{{ $transaction->notes }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td>{{ number_format($transaction->debit,2) }}</td>
                                    <td>{{ number_format($transaction->credit,2) }}</td>
                                    <td>{{ number_format( $bf,2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ number_format($transactions->sum('debit'),2) }}</td>
                                <td>{{ number_format($transactions->sum('credit'),2) }}</td>
                                <td>{{ number_format($bf,2) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No records found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <br>
                    <button class="btn btn-sm btn-info hidden-print pull-right" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('footer-scripts')

@endsection

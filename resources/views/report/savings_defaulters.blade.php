@extends('layouts.master')
@section('title')
    Defaulters
@endsection
@section('css')
    @include('report.includes.table-style')
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                Defaulters Report
                @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
            </h6>

            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                <div class="col-xs-3 col-xs-offset-1">
                    <label>Product</label>
                <select name="product" class="select2 form-control" required>
{{--                    <option value="">Select Product</option>--}}
{{--                    <option value="all">All Products</option>--}}
                    @if(count($products))
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        @endif
                </select>
                </div>
                <div class="col-xs-2">
                    <label>Minimum</label>
                    <input type="number" class="form-control" name="minimum">
                </div>
                <div class="col-xs-2">
                    <label>from</label>
                    {!! Form::text('start_date',$start_date?? \Carbon\Carbon::today()->startOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-2">
                    <label>to</label>
                    {!! Form::text('end_date',$end_date ?? \Carbon\Carbon::today()->endOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-2">
                    <button type="submit" class="btn btn-success btn-sm">{{trans_choice('general.search',1)}}!
                    </button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>

    <!-- /.box -->
    @if(isset($transactions) && !empty($transactions))
        <div class="panel panel-white">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th># </th>
                        <th>Name </th>
                        <th>Phone </th>
                        <th class="text-right">Amount </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($transactions))
                        @php $count= 1; @endphp
                        @foreach($transactions as $key => $transaction)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $transaction['name'] }}</td>
                                <td>{{ $transaction['phone'] }}</td>
                                <td class="text-right">{{ number_format($transaction['total'],2) }}</td>
                            </tr>
                            @php $count++ @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th class="text-right">{{ number_format($transactions->sum('total'),2) }}</th>
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

@extends('layouts.master')
@section('title')
    Collection Report
@endsection
@section('css')
    @include('report.includes.table-style')
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                Collection
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
                <div class="col-xs-2">
                    <label>Product</label>
                <select name="product" class="select2 form-control" required>
{{--                    <option value="">Select Product</option>--}}
                    <option value="all">All Products</option>
                    @if(count($products))
                        @foreach($products as $product)
                            <option value="{{ $product }}">{{ $product }}</option>
                            @endforeach
                        @endif
                </select>
                </div>
                <div class="col-xs-2">
                    <label>From</label>
                    {!! Form::text('start_date',$start_date?? \Carbon\Carbon::today()->startOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-2">
                    <label>To</label>
                    {!! Form::text('end_date',$end_date ?? \Carbon\Carbon::today()->endOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                </div>

                <div class="col-xs-2">
                    <label>Branch</label>
                    <select name="branch" class="form-control select2">
                        <option value="all">All</option>
                        @if(count($branches))
                            @foreach($branches as $v)
                                <option value="{{ $v->id }}">{{ $v->name}} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-xs-2">
                    <label>Clerk</label>
                    <select name="clerk" class="form-control select2">
                        <option value="all">All</option>
                        @if(count($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                            @endif
                    </select>
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
            <div class="panel-body table-responsive ">

                <h3>Collection</h3>
                @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th># </th>
                        <th>Name </th>
                        <th>{{trans_choice('general.product',1)}}</th>
                        <th>Branch </th>
                        {{--                        <th>{{trans_choice('general.type',1)}}</th>--}}
                        <th>{{trans_choice('general.date',2)}}</th>
                        <th>{{trans_choice('general.receipt',1)}}</th>
                        <th>Clerk </th>
                        <th class="text-right">Amount </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($transactions))
                        @php $count= 1;

                        @endphp
                        @foreach($transactions as $key => $transaction)
                            @php $user = \App\Models\User::find($transaction['clerk']);  @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $transaction['first_name'] }} {{ $transaction['last_name'] }}</td>
                                <td>{{ $transaction['name'] }}</td>
                                <td>{{ $transaction['branch'] }}</td>
                                <td>{{ $transaction['date'] }}</td>
                                <td>{{ $transaction['receipt'] }}</td>
                                <td>{{ $user->first_name ?? ''}} {{ $user->last_name?? '' }}</td>
                                <td class="text-right">{{ number_format($transaction['amount'],2) }}</td>
                            </tr>
                            @php $count++ @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th class="text-right">{{ number_format($transactions->sum('amount'),2) }}</th>
                        </tr>
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No records found</td>
                        </tr>
                    @endif
                    </tbody>

                </table>

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

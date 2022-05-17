@extends('layouts.master')
@section('title')
    Member Statement
@endsection
@section('css')
    @include('report.includes.table-style')
    @endsection
@section('content')
    <div class="panel panel-white hidden-print">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{trans_choice('general.borrower',1)}}  {{trans_choice('general.report',1)}}
                @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
            </h6>

        </div>
        <div class="panel-body hidden-print">
            <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                <div class="col-xs-4">
                    <select name="member_id" class="form-control select2">
                        <option value="">Select member</option>
                        @if(count($members))
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
                <div class="col-xs-4">
                    {!! Form::text('start_date',\Carbon\Carbon::today()->firstOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-4">
                    {!! Form::text('end_date',\Carbon\Carbon::today()->endOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <span class="input-group-btn">
                          <button type="submit" class="btn bg-olive btn-primary">{{trans_choice('general.search',1)}}!
                          </button>
                        </span>
{{--                        <span class="input-group-btn">--}}
{{--                          <a href="{{Request::url()}}"--}}
{{--                             class="btn bg-purple  btn-flat pull-right">{{trans_choice('general.reset',1)}}!</a>--}}
{{--                        </span>--}}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>
    <!-- /.box -->
    @if(isset($reports))
    <div class="panel panel-white">
        @include('report.includes.report-header')

        <div class="panel-body ">
            <div class="col-md-12">
                <table id="reports_table" class="table table-bordered table-condensed ">
                    <thead style="background-color: #F2F8FF">
                    <tr>
                        <td class="text-bold">Member</td>
                        <td class="text-bold" colspan="{{ 3 * count($savingProducts)+2 }}">{{ $member_name->first_name }} {{ $member_name->last_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Vehicles</td>
                        <td class="text-bold" colspan="{{ 3 * count($savingProducts)+2 }}">@if(count($vehicles))
                                @foreach($vehicles as $vehicle)
                                    {{ $vehicle->vehicle->vehicle}}
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">As At</td>
                        <td  class="text-bold" colspan="{{ 3 * count($savingProducts)+2 }}">{{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</td>
                    </tr>
                    <tr>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Vehicle</th>
                        <th rowspan="2">Ref</th>
                        @if(count($savingProducts))
                            @php
                                $balances = collect()
                            @endphp
                            @foreach($savingProducts as $savingProduct)
                                @php $balances = collect([
                                    'prod_id' => $savingProduct->id,
                                    'amount' => 0
                                ])@endphp
                                <th colspan="3" class="text-center">{{ $savingProduct->savings_product->name }}</th>
                            @endforeach
                        @endif
                    </tr>
                    <tr>
                        @if(count($savingProducts))
                            @foreach($savingProducts as $savingProduct)
                                <th class="text-right">Received</th>
                                <th class="text-right">Withdraw</th>
                                <th class="text-right">Running Balance</th>
                            @endforeach
                        @endif
                        <th>Total For The Day</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($savingProducts))
                        <tr>
                            <td class="text-center text-bold" colspan="3">BALANCE B/F</td>
                            @if(count($savingProducts))

                                @foreach($savingProducts as $savingProduct)

                                    @php
                                        $total = $savingsBf->where('savings_id',$savingProduct->id)->sum('credit') - $savingsBf->where('savings_id',$savingProduct->id)->sum('debit');
                                        $balances[] = collect([
                                    'prod_id' => $savingProduct->id,
                                    'amount' => $total
                                    ])

                                    @endphp
                                    <td colspan="3" class="text-right text-bold">{{ number_format($total,2)  }}</td>
                                @endforeach
                            @endif
                            <td></td>
                        </tr>


                        @foreach($dates as $date)
                            @php
                            $grossTotal = 0;
                                $total = 0;
                                $report = $reports
                                     ->whereBetween('date',[\Carbon\Carbon::parse($date)->startOfDay(),\Carbon\Carbon::parse($date)->endOfDay()])
//                                    ->where('date','>',\Carbon\Carbon::parse($date))
                                   //->where('date','<',\Carbon\Carbon::parse($date)->endOfDay())
                                ;

                             @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
                                <td>
                                    @if(count($vs = $report->where('vehicle','<>',null)->pluck('vehicle')))
                                    @foreach( $vs->unique() as $v)
                                        {{ $v->vehicle }}
                                         @endforeach
                                        @endif
                                </td>
                                <td>@foreach( $report->pluck('receipt')->unique() as $v)
                                        {{ $v }}
                                    @endforeach</td>
                                @if(count($savingProducts))

                                    @foreach($savingProducts as $savingProduct)
                                        @php $c=0;$d=0; @endphp
                                        <td class="text-right">@php $c =$report->where('savings_id',$savingProduct->id)/*->where('id',$report->id)*/->sum('credit') @endphp {{ ($c > 0)? number_format($c,2) : '-'  }}</td>
                                        <td class="text-right"> @php $d =$report->where('savings_id',$savingProduct->id)/*->where('id',$report->id)*/->sum('debit') @endphp {{ ($d >0 )?number_format($d,2) : '-' }}</td>
                                        @php $balances[] = collect([
                                            'prod_id' => $savingProduct->id,
                                            'amount' => $c
                                    ]);

                                        $total = $total + $c + $d;
                                        $grossTotal = $grossTotal + $total;
                                    $balances[] = collect([
                                            'prod_id' => $savingProduct->id,
                                            'amount' => -$d
                                    ]
                                    )

                                        @endphp
                                        <td class="text-right text-bold">{{ number_format($balances->where('prod_id',$savingProduct->id)->sum('amount'),2) }}</td>
                                    @endforeach
                                    <td>{{ number_format($total,2) }}</td>
                                @endif
                            </tr>
                            @endforeach
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-bold">Totals</td>
                            @if(count($savingProducts))
                                @foreach($savingProducts as $savingProduct)
                                    <td class="text-right text-bold"><strong> {{ number_format($reports->where('savings_id',$savingProduct->id)->sum('credit'),2) }}</strong></td>
                                    <td class="text-right text-bold">{{ number_format($reports->where('savings_id',$savingProduct->id)->sum('debit'),2) }}</td>
                                    <td class="text-right text-bold">{{ number_format($balances->where('prod_id',$savingProduct->id)->sum('amount'),2) }}</td>
                                @endforeach
                            @endif
{{--                            <td>{{ number_format($grossTotal,2) }}</td>--}}
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <br>
            <br>
            <div class="col-md-5">

            </div>
            <div class="col-md-7">

                @if(count($loans))
                    <h3>Loan Balances</h3>
                    @foreach($loans as $loan)

{{--                        <div class="table-responsive">--}}
                            <table id="repayments-data-table"
                                   class="table  table-condensed table-hover">
                                <thead>
                                <tr>

                                    <th>
                                        {{trans_choice('general.date',1)}}
                                    </th>
                                    <th>
                                        Loan Type
                                    </th>
                                    <th>
                                        {{trans_choice('general.type',1)}}
                                    </th>

                                    <th>
                                        {{trans_choice('general.debit',1)}}
                                    </th>
                                    <th>
                                        {{trans_choice('general.credit',1)}}
                                    </th>
                                    <th>
                                        {{trans_choice('general.balance',1)}}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
{{--                                @if(count($loans))--}}
                                    @foreach($loan as $loanD)
                                        <tr>
                                            <td>{{ $loanD['date'] }}</td>
                                            <td>{{ $loanD['loan'] }}</td>
                                            <td>{{ $loanD['type'] }}</td>
                                            <td>{{ ($loanD['debit'] != 0)? number_format($loanD['debit'],2) : '-' }}</td>
                                            <td>{{ ($loanD['credit'] != 0)? number_format($loanD['credit'],2) : '-' }}</td>
                                            <th>{{ number_format($loanD['balance'],2) }}</th>
                                        </tr>
                                    @endforeach
{{--                                    @endif--}}
                                </tbody>
                            </table>
{{--                        </div>--}}
                        <br>
                        <br>
                        <br>
                    @endforeach
                    @endif
            </div>

                <div class="col-md-12">


                    <p>
                       <br>
                       <strong>Approved By:</strong>
                       <br>
                       <br>
                        _________________________________________________________
                    </p>

                </div>

            <div class="col-md-12">
                <br>
                <button class="btn btn-sm btn-info hidden-print pull-right" onclick="window.print()">Print</button>
            </div>
{{--            </div>--}}
        </div>
    </div>

    @endif
@endsection
@section('footer-scripts')

    <script>
    </script>
@endsection

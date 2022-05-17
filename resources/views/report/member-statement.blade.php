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

        <div class="panel-body table-responsive">
            <div class="col-md-12">
                <table id="reports_table" class="table table-bordered table-condensed ">
                    <thead style="background-color: #F2F8FF">
                    <tr>
                        <td class="text-bold">Member</td>
                        <td class="text-bold" colspan="{{ 3 * count($savingProducts)+2 }}">{{ $member_name->first_name }} {{ $member_name->last_name }}</td>
                    </tr>

                    <tr>
                        <td class="text-bold">As At</td>
                        <td  class="text-bold" colspan="{{ 3 * count($savingProducts)+2 }}">{{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</td>
                    </tr>
                    <tr>
                        <th rowspan="2">Date</th>
                        <th rowspan="2"></th>
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
                        </tr>
                        @foreach($reports as $report)

                            <tr>
                                <td>{{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}</td>
                                <td>{{ (!is_null($report->vehicle))? $report->vehicle->vehicle : '' }}</td>
                                <td>{{ $report->receipt }}</td>
                                @if(count($savingProducts))

                                    @foreach($savingProducts as $savingProduct)
                                        @php $c=0;$d=0; @endphp
                                        <td class="text-right">@php $c =$reports->where('savings_id',$savingProduct->id)->where('id',$report->id)->sum('credit') @endphp {{ ($c > 0)? number_format($c,2) : '-'  }}</td>
                                        <td class="text-right"> @php $d =$reports->where('savings_id',$savingProduct->id)->where('id',$report->id)->sum('debit') @endphp {{ ($d >0 )?number_format($d,2) : '-' }}</td>
                                        @php $balances[] = collect([
                                            'prod_id' => $savingProduct->id,
                                            'amount' => $c
                                    ]
                                    );
                                    $balances[] = collect([
                                            'prod_id' => $savingProduct->id,
                                            'amount' => -$d
                                    ]
                                    )

                                        @endphp
                                        <td class="text-right text-bold">{{ number_format($balances->where('prod_id',$savingProduct->id)->sum('amount'),2) }}</td>
                                    @endforeach
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
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <br>
            <br>
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

                @if(count($loans))
                    <h3>Loan Details</h3>
                    @foreach($loans as $loan)

                        <div class="table-responsive">
                            <table id="repayments-data-table"
                                   class="table  table-condensed table-hover">
                                <thead>
                                <tr>

                                    <th>
                                        {{trans_choice('general.date',1)}}
                                    </th>
                                    <th>
                                        Reference
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
                                <?php
                                $balance = 0;
                                ?>
                                @foreach(\App\Models\LoanTransaction::where('loan_id',$loan->id)->whereIn('reversal_type',['user','none'])->get() as $key)
                                    <?php
                                    $balance = $balance + ($key->debit - $key->credit);
                                    ?>
                                    <tr>
{{--                                        <td>{{$key->id}}</td>--}}
                                        <td>{{$key->date}}</td>
                                        <td>{{$key->receipt}}</td>
                                        <td>
                                            @if($key->transaction_type=='disbursement')
                                                {{trans_choice('general.disbursement',1)}}
                                            @endif
                                            @if($key->transaction_type=='specified_due_date_fee')
                                                {{trans_choice('general.specified_due_date',2)}}   {{trans_choice('general.fee',1)}}
                                            @endif
                                            @if($key->transaction_type=='installment_fee')
                                                {{trans_choice('general.installment_fee',2)}}
                                            @endif
                                            @if($key->transaction_type=='overdue_installment_fee')
                                                {{trans_choice('general.overdue_installment_fee',2)}}
                                            @endif
                                            @if($key->transaction_type=='loan_rescheduling_fee')
                                                {{trans_choice('general.loan_rescheduling_fee',2)}}
                                            @endif
                                            @if($key->transaction_type=='overdue_maturity')
                                                {{trans_choice('general.overdue_maturity',2)}}
                                            @endif
                                            @if($key->transaction_type=='disbursement_fee')
                                                {{trans_choice('general.disbursement',1)}} {{trans_choice('general.charge',2)}}
                                            @endif
                                            @if($key->transaction_type=='interest')
                                                {{trans_choice('general.interest',1)}} {{trans_choice('general.applied',2)}}
                                            @endif
                                            @if($key->transaction_type=='repayment')
                                                {{trans_choice('general.repayment',1)}}
                                            @endif
                                            @if($key->transaction_type=='penalty')
                                                {{trans_choice('general.penalty',1)}}
                                            @endif
                                            @if($key->transaction_type=='interest_waiver')
                                                {{trans_choice('general.interest',1)}} {{trans_choice('general.waiver',2)}}
                                            @endif
                                            @if($key->transaction_type=='waiver')
                                                {{trans_choice('general.waiver',2)}}
                                            @endif
                                            @if($key->transaction_type=='charge_waiver')
                                                {{trans_choice('general.charge',1)}}  {{trans_choice('general.waiver',2)}}
                                            @endif
                                            @if($key->transaction_type=='write_off')
                                                {{trans_choice('general.write_off',1)}}
                                            @endif
                                            @if($key->transaction_type=='write_off_recovery')
                                                {{trans_choice('general.recovery',1)}} {{trans_choice('general.repayment',1)}}
                                            @endif
                                            @if($key->reversed==1)
                                                @if($key->reversal_type=="user")
                                                    <span class="text-danger"><b>({{trans_choice('general.user',1)}} {{trans_choice('general.reversed',1)}}
                                                                                    )</b></span>
                                                @endif
                                                @if($key->reversal_type=="system")
                                                    <span class="text-danger"><b>({{trans_choice('general.system',1)}} {{trans_choice('general.reversed',1)}}
                                                                                    )</b></span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{number_format($key->debit,2)}}</td>
                                        <td>{{number_format($key->credit,2)}}</td>
                                        <td>{{number_format($balance,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                    @endif
            </div>
{{--            <div class="col-md-6">--}}
{{--                @if(count($loans))--}}
{{--                    @foreach($loans as $loan)--}}
{{--                            <div style="width: 300px;margin-right: 40px;float: left">--}}
{{--                                <b>{{trans_choice('general.loan',1)}} #</b><span class="pull-right">{{$loan->id}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.released',1)}}</b><span class="pull-right">{{$loan->release_date}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.maturity_date',1)}}</b><span class="pull-right">{{$loan->maturity_date}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.repayment',1)}}</b><span class="pull-right" style="">{{$loan->repayment_cycle}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.principal',1)}}</b><span class="pull-right" style="">{{number_format($loan->principal,2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.interest',1)}}%</b><span class="pull-right" style="">{{number_format($loan->interest_rate,2)}}--}}
{{--                                 %/{{$loan->interest_period}}</span><br><br>--}}
{{--                            </div>--}}
{{--                            <div style="width: 300px;float: left">--}}
{{--                                <b>{{trans_choice('general.interest',1)}} </b><span--}}
{{--                                        class="pull-right">{{number_format(\App\Helpers\GeneralHelper::loan_total_interest($loan->id),2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.fee',2)}}</b><span--}}
{{--                                        class="pull-right">{{number_format(\App\Helpers\GeneralHelper::loan_total_fees($loan->id),2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.penalty',1)}}</b><span--}}
{{--                                        class="pull-right">{{number_format(\App\Helpers\GeneralHelper::loan_total_penalty($loan->id),2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.due',1)}}</b><span class="pull-right"--}}
{{--                                                                              style="">{{number_format(\App\Helpers\GeneralHelper::loan_total_due_amount($loan->id),2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.paid',1)}}</b><span class="pull-right"--}}
{{--                                                                               style="">{{number_format(\App\Helpers\GeneralHelper::loan_total_paid($loan->id),2)}}</span><br><br>--}}
{{--                                <b>{{trans_choice('general.balance',1)}}</b><span class="pull-right"--}}
{{--                                                                                  style="">{{number_format(\App\Helpers\GeneralHelper::loan_total_balance($loan->id),2)}}</span><br><br>--}}
{{--                            </div>--}}
{{--                            <h3 class="text-center"><b>{{trans_choice('general.repayment',2)}}</b></h3>--}}

{{--                            <table class="table table-condensed table-bordered table-striped">--}}
{{--                                <thead>--}}
{{--                                <tr style="background-color: #F2F8FF">--}}
{{--                                    <th>--}}
{{--                                        {{trans_choice('general.collection',1)}} {{trans_choice('general.date',1)}}--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        {{trans_choice('general.collected_by',1)}}--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        {{trans_choice('general.method',1)}}--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        {{trans_choice('general.amount',1)}}--}}
{{--                                    </th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach(\App\Models\LoanTransaction::where('loan_id',$loan->id)->where('transaction_type','repayment')->where('reversed',0)->get() as $key)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{$key->date}}</td>--}}
{{--                                        <td>--}}
{{--                                            @if(!empty($key->user))--}}
{{--                                                {{$key->user->first_name}} {{$key->user->last_name}}--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if(!empty($key->loan_repayment_method))--}}
{{--                                                {{$key->loan_repayment_method->name}}--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>{{number_format($key->credit,2)}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}

{{--                    @endforeach--}}

{{--                @endif--}}
{{--            </div>--}}




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

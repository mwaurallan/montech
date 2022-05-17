@extends('layouts.master')
@section('title')
    {{trans_choice('general.saving',2)}} {{trans_choice('general.transaction',2)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{trans_choice('general.saving',2)}} {{trans_choice('general.transaction',2)}}
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
                <div class="col-xs-2 col-md-offset-1">
                    <select name="product_id" class="form-control select2" required>
                        <option value="">Select Product</option>
                        @if(count($products))
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"> {{ $product->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-xs-2 ">
                    <select name="branch_id" class="form-control select2">
                        <option value="all">All Branches</option>
                        @if(count($branches))
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"> {{ $branch->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-xs-3">
                    {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-3">
                    {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"To Date",'required'=>'required')) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

                        <div class="btn-group">
                            <button type="button" class="btn bg-blue dropdown-toggle legitRipple"
                                    data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{url('report/savings_report/savings_transactions/pdf?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/savings_report/savings_transactions/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/savings_report/savings_transactions/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-download"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}
                                    </a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>

    <!-- /.box -->
    @if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.borrower',1)}}</th>
                        <th>{{trans_choice('general.product',1)}}</th>
                        <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_deposited = 0;
                    $total_withdrawn = 0;
                    $balance = 0;

                    ?>
                    @foreach($members as $member)
                        @php
                            $key = $data->where('borrower_id','=',$member);
                            $cr = $key->sum('credit');
                            $dr = $key->sum('debit');
                            $total_deposited = $total_deposited + $dr;
                            $total_withdrawn = $total_withdrawn + $cr;
                        @endphp
                        <tr>
                            <td>{{ $key->first()->borrower->first_name }} {{ $key->first()->borrower->middle_name }} {{ $key->first()->borrower->last_name }}</td>
                            <td>{{ $prod }}</td>
                            <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                            <td>{{ number_format( $bal = \App\Helpers\GeneralHelper::savings_account_balance( $key->first()->savings_id),2) }}</td>
                        </tr>
                        @php $balance = $balance + $bal; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($total_deposited,2)}}</b></td>
                        <td><b>{{number_format($total_withdrawn,2)}}</b></td>
                        <td><b>{{number_format($balance,2)}}</b></td>
                    </tr>
                    </tfoot>
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

@extends('layouts.master')
@section('title')
    Sms Report
@endsection
@section('css')
    @include('report.includes.table-style')
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                Sms Collection
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
                <div class="col-xs-4 col-xs-offset-2">
                    <label>From</label>
                    {!! Form::text('start_date',$start_date?? \Carbon\Carbon::today()->startOfMonth()->toDateString(), array('class' => 'form-control date-picker', 'placeholder'=>"From Date",'required'=>'required')) !!}
                </div>
                <div class="col-xs-4">
                    <label>To</label>
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
    @if(isset($messages) && !empty($messages))
        <div class="panel panel-white">
            @include('report.includes.report-header')
            <div class="panel-body table-responsive ">

                <h3>Sms Sent</h3>
                @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th># </th>
                        <th>Message</th>
                        <th>Date </th>
                        <th class="text-right">Cost </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($messages))
                        @php $count= 1;
                            $total = 0;
                        @endphp
                        @foreach($messages as $key => $message)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->created_at }}</td>
                                <td class="text-right">{{ number_format($cost = $message->count,2) }}</td>
                            </tr>
                            @php $count++; $total = $total+ $cost; @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Sub Total</td>
                            <td class="text-right">{{ number_format($total) }}</td>
                        </tr>
{{--                        <tr>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td>VAT</td>--}}
{{--                            <td class="text-right">{{ number_format($total * 0.14) }}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td>Total</td>--}}
{{--                            <td class="text-right">{{ number_format($total * 1.14) }}</td>--}}
{{--                        </tr>--}}
                        @else
                        <tr>
                            <td colspan="4" class="text-center">No records found</td>
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

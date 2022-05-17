@extends('layouts.master')
@section('title')
    Outstanding Principal Report
@endsection
@section('css')
    @include('report.includes.table-style')
    @endsection
@section('content')
{{--    <div class="panel panel-white hidden-print">--}}
{{--        <div class="panel-heading">--}}

{{--        </div>--}}
{{--        <div class="panel-body hidden-print">--}}
{{--            <h4 class="">Filter</h4>--}}
{{--            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}--}}
{{--            <div class="row">--}}
{{--                <div class="col-xs-4 col-md-offset-2">--}}
{{--                    <select name="product" class="form-control select2">--}}
{{--                        <option value="">All Saving Products</option>--}}
{{--                        @if(count($products))--}}
{{--                            @foreach($products as $product)--}}
{{--                                <option value="{{ $product->id }}">{{ $product->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-xs-2">--}}
{{--                        <span class="input-group-btn">--}}
{{--                          <button type="submit" class="btn bg-olive btn-primary">{{trans_choice('general.search',1)}}!--}}
{{--                          </button>--}}
{{--                        </span>--}}
{{--                    <span class="input-group-btn">--}}
{{--                          <a href="{{Request::url()}}"--}}
{{--                             class="btn bg-purple  btn-flat pull-right">{{trans_choice('general.reset',1)}}!</a>--}}
{{--                        </span>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="panel-body">--}}
{{--                <div class="row">--}}

{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}

{{--        </div>--}}
{{--        <!-- /.panel-body -->--}}

{{--    </div>--}}
    <!-- /.box -->
    @if(isset($reports))
    <div class="panel panel-white">
        @include('report.includes.report-header')

        <div class="panel-body ">
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-condensed table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans_choice('general.borrower',1)}}</th>
                    <th>{{trans_choice('general.product',1)}}</th>
                    <th class="text-right" style="padding-right: 20px;">Outstanding Principal</th>
{{--                    <th>{{ trans_choice('general.action',1) }}</th>--}}
                </tr>
                </thead>
                <tbody>
                @php $allTotal = 0; $count = 1; @endphp
                @if(count($reports))
                @foreach($reports as $key)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>
                            @if(!empty($key->borrower))
                                {{ $key->borrower->first_name }} {{ $key->borrower->last_name }}
                            @endif
                        </td>
                        <td>
                            @if(!empty($key->loan_product))
                                {{ $key->loan_product->name }}
                            @endif
                        </td>
                        @php
                        $loan = $key;
                                        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($loan->id,
                                            $loan->release_date, date("Y-m-d"));

                                $total = \App\Helpers\GeneralHelper::loan_total_principal($loan->id)-$loan_paid_items['principal'];
                                    $allTotal = $allTotal + $total; $count++
                        @endphp
                        <td class="text-right" style="padding-right: 20px;">{{ number_format($total ,2) }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th class="text-right" style="padding-right: 20px;">{{ number_format($allTotal,2) }}</th>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

            <div class="col-md-12">
                <br>
                <br>
                <button class="btn btn-sm btn-info hidden-print pull-right" onclick="window.print()">Print</button>
            </div>
        </div>


    </div>

    @endif
@endsection
@section('footer-scripts')

    <script>
    </script>
@endsection

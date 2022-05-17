@extends('layouts.master')
@section('title')
    Cumulative Report
@endsection
@section('css')
    @include('report.includes.table-style')
    @endsection
@section('content')
    <div class="panel panel-white hidden-print">
        <div class="panel-heading">

        </div>
        <div class="panel-body hidden-print">
            <h4 class="">Filter</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                <div class="col-xs-2 col-md-offset-2">
                    <select name="product" class="form-control select2">
                        <option value="">All Saving Products</option>
                        @if(count($products))
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                <div class="col-xs-2">
                        <span class="input-group-btn">
                          <button type="submit" class="btn bg-olive btn-primary">{{trans_choice('general.search',1)}}!
                          </button>
                        </span>
                    <span class="input-group-btn">
                          <a href="{{Request::url()}}"
                             class="btn bg-purple  btn-flat pull-right">{{trans_choice('general.reset',1)}}!</a>
                        </span>
                </div>

            </div>
            <div class="panel-body">
                <div class="row">

                </div>
            </div>
            {!! Form::close() !!}

        </div>
{{--        <!-- /.panel-body -->--}}

    </div>
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
                    <th class="text-right" style="padding-right: 20px;">Total</th>
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
                            @if(!empty($key->savings_product))
                                {{ $key->savings_product->name }}
                            @endif
                        </td>
                        <td class="text-right" style="padding-right: 20px;">{{ number_format($total = \App\Helpers\GeneralHelper::savings_account_balance($key->id),2) }}</td>
                        @php $allTotal = $allTotal + $total; $count++ @endphp
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

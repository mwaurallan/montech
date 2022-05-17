@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <!---Income, Expense and Profit Line Chart-->
        <div class="col-md-12">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Total Savings</p>
                        <h3><span id="bal-span">{{ number_format($totalSavings,2) }} </span><sup style="font-size: 20px">Ksh</sup></h3>

                    </div>
                    <div class="icon">
                        <i class="fa fa-angle-down-bar"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{--{!! Charts::assets() !!}--}}
@endpush
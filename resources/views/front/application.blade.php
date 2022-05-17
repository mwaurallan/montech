@extends('layouts.customer')
@section("pageTitle",'Apply Loan')
{{--@section("pageSubtitle",'manage loan applications')--}}
@section("breadcrumbs")
    <li>Home</li>
    <li>Loan </li>
    <li class="active">Apply Loan</li>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css') }}">

    <link rel="stylesheet" href="{{ asset('wizard/css/style.css') }}">
    <!-- STYLE CSS -->
@endsection
@section('content')
    @php $val = 1; @endphp
    <section class="content-header">
        <h1 class="pull-right">
            {{--<a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>--}}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="box ">
            <div class="box-body">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Total savings</p>
                            <h3><span id="bal-span">{{ number_format($totalSavings,2) }}</span><sup style="font-size: 20px"> Ksh</sup></h3>

                        </div>
                        {{--<div class="icon">--}}
                            {{--<i class="ion ion-stats-bars"></i>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Max Loan Amount</p>
                            <h3><span id="bal-span">{{ number_format($totalSavings * 3,2) }}</span><sup style="font-size: 20px"> Ksh</sup></h3>

                        </div>
                        {{--<div class="icon">--}}
                            {{--<i class="ion ion-stats-bars"></i>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-body">
                <div class="wizard">
                    <form action="" id="wizard">
                        <!-- SECTION 1 -->
                        <h2></h2>
                        <section>
                            <div class="inner">
                                <div class="image-holder">
                                    <img src="{{ asset('wizard/images/form-wizard-1.jpg') }}" alt="">
                                </div>
                                <div class="form-content" >
                                    <div class="form-header">
                                        <h3>Registration</h3>
                                    </div>
                                    <p>Please fill with your details</p>
                                    <div class="form-row">
                                        <div class="form-holder">
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                        <div class="form-holder">
                                            <input type="text" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-holder">
                                            <input type="text" placeholder="Your Email" class="form-control">
                                        </div>
                                        <div class="form-holder">
                                            <input type="text" placeholder="Phone Number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-holder">
                                            <input type="text" placeholder="Age" class="form-control">
                                        </div>
                                        <div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
                                            <div class="checkbox-tick">
                                                <label class="male">
                                                    <input type="radio" name="gender" value="male" checked> Male<br>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="female">
                                                    <input type="radio" name="gender" value="female"> Female<br>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox-circle">
                                        <label>
                                            <input type="checkbox" checked> Nor again is there anyone who loves or pursues or desires to obtaini.
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 2 -->
                        <h2></h2>
                        <section>
                            <div class="inner">
                                <div class="image-holder">
                                    <img src="{{ asset('wizard/images/form-wizard-2.jpg') }}" alt="">
                                </div>
                                <div class="form-content">
                                    <div class="form-header">
                                        <h3>Registration</h3>
                                    </div>
                                    <p>Please fill with additional info</p>
                                    <div class="form-row">
                                        <div class="form-holder w-100">
                                            <input type="text" placeholder="Address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-holder">
                                            <input type="text" placeholder="City" class="form-control">
                                        </div>
                                        <div class="form-holder">
                                            <input type="text" placeholder="Zip Code" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="select">
                                            <div class="form-holder">
                                                <div class="select-control">Your country</div>
                                                <i class="zmdi zmdi-caret-down"></i>
                                            </div>
                                            <ul class="dropdown">
                                                <li rel="United States">United States</li>
                                                <li rel="United Kingdom">United Kingdom</li>
                                                <li rel="Viet Nam">Viet Nam</li>
                                            </ul>
                                        </div>
                                        <div class="form-holder"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 3 -->
                        <h2></h2>
                        <section>
                            <div class="inner">
                                <div class="image-holder">
                                    <img src="{{ asset('wizard/images/form-wizard-3.jpg') }}" alt="">
                                </div>
                                <div class="form-content">
                                    <div class="form-header">
                                        <h3>Registration</h3>
                                    </div>
                                    <p>Send an optional message</p>
                                    <div class="form-row">
                                        <div class="form-holder w-100">
                                            <textarea name="" id="" placeholder="Your messagere here!" class="form-control" style="height: 99px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="checkbox-circle mt-24">
                                        <label>
                                            <input type="checkbox" checked>  Please accept <a href="#">terms and conditions ?</a>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
        {{--<div class="box box-success">--}}
            {{--<div class="box-body">--}}
                {{--<form>--}}

                    {{--<div class="col-xs-12">--}}
                        {{--<div class="col-md-12">--}}
                        {{--<!-- Agent Id Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                        {{--{!! Form::label('agent_id', 'Agent Id:') !!}--}}
                        {{--{!! Form::number('agent_id', null, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Client Id Field -->--}}
                            {{--<input type="hidden" name="client_id" value="{{\Illuminate\Support\Facades\Auth::user()->mf_id}}">--}}

                            {{--<!-- Product Id Field -->--}}
                            {{--<div class="form-group col-sm-12">--}}
                                {{--{!! Form::label('product_id', 'Loan product:') !!}--}}
                                {{--<select name="product_id" class="form-control select2" required>--}}
                                    {{--<option value="">Select loan product</option>--}}
                                    {{--@if(count($loan_products))--}}
                                        {{--@foreach($loan_products as $loan_product)--}}
                                            {{--<option value="{{ $loan_product->id }}">{{ $loan_product->name }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<!-- Rate Field -->--}}
                            {{--<div class="form-group col-sm-12">--}}
                                {{--{!! Form::label('rate', 'Rate:') !!}--}}
                                {{--<select name="rate" class="form-control select2" required>--}}
                                    {{--<option value="">Select rate</option>--}}
                                    {{--@if(count($rates))--}}
                                        {{--@foreach($rates as $rate)--}}
                                            {{--<option value="{{ $rate->id }}">{{ $rate->rate }} %</option>--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            {{--</div>--}}

                        {{--<!-- Interest Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                        {{--{!! Form::label('interest', 'Interest:') !!}--}}
                        {{--{!! Form::number('interest', null, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Amount Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                        {{--{!! Form::label('amount', 'Amount:') !!}--}}
                        {{--{!! Form::number('amount', null, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Status Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                        {{--{!! Form::label('status', 'Status:') !!}--}}
                        {{--{!! Form::text('status', null, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Installments Field -->--}}
                            {{--<div class="form-group col-sm-12">--}}
                                {{--{!! Form::label('installments', 'Installments:') !!}--}}
                                {{--<select name="installments" class="select2 form-control" required>--}}
                                    {{--<option value="4">4</option>--}}
                                    {{--<option value="1">1</option>--}}
                                    {{--<option value="2">2</option>--}}
                                    {{--<option value="3">3</option>--}}
                                    {{--<option value="5">5</option>--}}
                                    {{--<option value="6">6</option>--}}
                                    {{--<option value="7">7</option>--}}
                                    {{--<option value="8">8</option>--}}
                                    {{--<option value="9">9</option>--}}
                                    {{--<option value="10">3</option>--}}
                                    {{--<option value="11">11</option>--}}
                                    {{--<option value="12">12</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<!-- Period Field -->--}}
                            {{--<div class="form-group col-sm-12">--}}
                                {{--{!! Form::label('period', 'Loan Period:') !!}--}}
                                {{--<select name="period" class="select2 form-control" required>--}}
                                    {{--@if(count($periods))--}}
                                        {{--@foreach($periods as $period)--}}
                                            {{--<option value="{{ $period->period }}">{{$period->period.' days'}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<br>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-12">--}}
                            {{--<button class="btn btn-primary btn-sm nextBtn btn-lg pull-right" type="button" >Next</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="text-center">

        </div>
    </div>
@endsection


@push('js')
    {{--<script src="{{ asset('wizard/js/jquery-3.3.1.min.js')}}"></script>--}}
    <script src="{{ asset('wizard/js/jquery.steps.js')}}"></script>
    <script src="{{ asset('wizard/js/main.js') }}"></script>
    <script>

        $('a#applyLoan').parent('li').addClass('active').parent('ul').parent().addClass('active');
    </script>
@endpush
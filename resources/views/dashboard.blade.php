@extends('layouts.master')
@section('title')
    {{ trans('general.dashboard') }}
@endsection
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /*body{*/
        /*margin-top:40px;*/
        /*}*/
        .no-padding-left{
            padding-left: 0;
        }
        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($invoices > 0 && \Carbon\Carbon::today() > \Carbon\Carbon::today()->firstOfMonth()->addDays(0)->startOfDay())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-alert"></i> Important!</h4>
                    Please clear your due invoice(s) by {{ \Carbon\Carbon::today()->firstOfMonth()->addDays(4)->format("d M Y") }} to avoid service suspension <a href="{{ url('invoices') }}">Click here to view more details</a>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="panel panel-body bg-success-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3><span id="bal-span"></span><sup style="font-size: 20px"> Available Credits</sup><span class="pull-right" style="font-size: 20px"></span></h3>
{{--                        <h3><span id="sms-available">...</span> <sup style="font-size: 20px"> Available SMS</sup></h3>--}}
                        <a href="#purchase-modal" data-toggle="modal" class="text-uppercase text-size-mini btn btn-primary btn-block">Purchase Sms <i class="fa fa-arrow-circle-right"></i></a>

                    </div>

{{--                    <div class="media-right media-middle">--}}
{{--                        <i class="icon-users4 icon-3x opacity-75"></i>--}}
{{--                    </div>--}}
                </div>
            </div>
            <!-- small box -->

        </div>
        @if(Sentinel::hasAccess('dashboard.registered_borrowers'))
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="panel panel-body bg-blue-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            <h3 class="no-margin">{{ \App\Models\Borrower::count() }}</h3>
                            <span class="text-uppercase text-size-mini">{{ trans_choice('general.total',1) }} {{ trans_choice('general.borrower',2) }}</span>
                        </div>

                        <div class="media-right media-middle">
                            <i class="icon-users4 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(Sentinel::hasAccess('dashboard.total_loans_released'))
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="panel panel-body bg-indigo-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                <h3 class="no-margin"> {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format(\App\Helpers\GeneralHelper::loans_total_principal(),2) }} </h3>
                            @else
                                <h3 class="no-margin"> {{ number_format(\App\Helpers\GeneralHelper::loans_total_principal(),2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h3>
                            @endif
                            <span class="text-uppercase text-size-mini">{{ trans_choice('general.loan',2) }} {{ trans_choice('general.released',1) }}</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-drawer-out icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(Sentinel::hasAccess('dashboard.total_collections'))
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="panel panel-body bg-success-400">
                    <div class="media no-margin">
                        <div class="media-body">
                            @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                <h3 class="no-margin"> {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }} </h3>
                            @else
                                <h3 class="no-margin"> {{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h3>
                            @endif
                            <span class="text-uppercase text-size-mini">{{ trans_choice('general.payment',2) }}</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-enter6 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="panel panel-body bg-danger-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                <h3 class="no-margin"> {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format(\App\Helpers\GeneralHelper::loans_total_due(),2) }} </h3>
                            @else
                                <h3 class="no-margin"> {{ number_format(\App\Helpers\GeneralHelper::loans_total_due(),2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h3>
                            @endif
                            <span class="text-uppercase text-size-mini">{{ trans_choice('general.due',1) }} {{ trans_choice('general.amount',1) }}</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-pen-minus icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
            <div class="col-md-4">
                <div class="panel panel-flat">
                    <div class="panel-body">

                        <canvas id="loan_status_pie" height="300"></canvas>
                        <div class="list-group no-border no-padding-top">
                            @foreach(json_decode($loan_statuses) as $key)
                                <a href="{{$key->link}}" class="list-group-item">
                                    <span class="badge bg-{{$key->class}} pull-right">{{$key->value}}</span>
                                    {{$key->label}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-8">
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
            <!-- Sales stats -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans_choice('general.collection',1) }} {{ trans_choice('general.statistic',2) }}</h6>
                        <div class="heading-elements">
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $target = 0;
                        foreach (\App\Models\LoanSchedule::where('year', date("Y"))->where('month',
                            date("m"))->get() as $key) {
                            $target = $target + $key->principal + $key->interest + $key->fees + $key->penalty;
                        }
                        $paid_this_month = \App\Models\LoanTransaction::where('transaction_type',
                            'repayment')->where('reversed', 0)->where('year', date("Y"))->where('month',
                            date("m"))->sum('credit');
                        if ($target > 0) {
                            $percent = round(($paid_this_month / $target) * 100);
                        } else {
                            $percent = 0;
                        }

                        ?>
                        <div class="container-fluid">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="content-group">
                                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                            <h5 class="text-semibold no-margin">{{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format(\App\Models\LoanTransaction::where('transaction_type',
                    'repayment')->where('reversed', 0)->where('date',date("Y-m-d"))->sum('credit'),2) }}  </h5>
                                        @else
                                            <h5 class="text-semibold no-margin">{{ number_format(\App\Models\LoanTransaction::where('transaction_type',
                    'repayment')->where('reversed', 0)->where('date',date("Y-m-d"))->sum('credit'),2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h5>
                                        @endif

                                        <span class="text-muted text-size-small">{{ trans_choice('general.today',1) }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="content-group">
                                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                            <h5 class="text-semibold no-margin">{{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format(\App\Models\LoanTransaction::where('transaction_type',
                    'repayment')->where('reversed', 0)->whereBetween('date',array('date_sub(now(),INTERVAL 1 WEEK)','now()'))->sum('credit'),2) }} </h5>
                                        @else
                                            <h5 class="text-semibold no-margin">{{ number_format(\App\Models\LoanTransaction::where('transaction_type',
                    'repayment')->where('reversed', 0)->whereBetween('date',array('date_sub(now(),INTERVAL 1 WEEK)','now()'))->sum('credit'),2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h5>
                                        @endif
                                        <span class="text-muted text-size-small">{{ trans_choice('general.last',1) }} {{ trans_choice('general.week',1) }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="content-group">
                                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                                            <h5 class="text-semibold no-margin">{{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value }}{{ number_format($paid_this_month,2) }} </h5>
                                        @else
                                            <h5 class="text-semibold no-margin">{{ number_format($paid_this_month,2) }}  {{ \App\Models\Setting::where('setting_key', 'currency_symbol')->first()->setting_value}}</h5>
                                        @endif
                                        <span class="text-muted text-size-small">{{ trans_choice('general.this',1) }} {{ trans_choice('general.month',1) }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <h6 class="no-margin text-semibold">{{ trans_choice('general.monthly',1) }} {{ trans_choice('general.target',1) }}</h6>
                                    </div>
                                    <div class="progress" data-toggle="tooltip"
                                         title="Target:{{number_format($target,2)}}">

                                        <div class="progress-bar bg-teal progress-bar-striped active"
                                             style="width: {{$percent}}%">
                                            <span>{{$percent}}% {{ trans_choice('general.complete',1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(Sentinel::hasAccess('dashboard.loans_collected_monthly_graph'))
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans_choice('general.monthly',1) }} {{trans_choice('general.overview',1)}}</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="monthly_actual_expected_data" class="chart" style="height: 320px;">
                        </div>
                    </div>
                </div>
            @endif
        </div>
            <div class="modal fade" id="purchase-modal" role="dialog">
                <form>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Purchase Sms</h4>
                            </div>

                            <div class="modal-body" id="content-modal" style="">

                                <div class="stepwizard">
                                    <div class="stepwizard-row setup-panel">
                                        <div class="stepwizard-step">
                                            <a href="#step-1" id="first" type="button" class="btn btn-primary btn-circle">1</a>
                                            <p>Payment Data</p>
                                        </div>
                                        <div class="stepwizard-step">
                                            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                            <p>Payment Summary</p>
                                        </div>


                                    </div>
                                </div>
                                <div class="row setup-content" id="step-1">
                                    <div class="col-xs-12">
                                        <div class="col-md-12">
                                            <form name="registration_form" id="registration_form" class="form-inline">
                                                <div class="form-group col-xs-12">
                                                    <label for="gross_amount" class="sr-only">Gross Amount</label>
                                                    <input id="gross_amount" required class="form-control input-group-lg" type="text" name="gross_amount" title="Enter gross amount" placeholder="Gross Amount">
                                                </div>
                                                <div class="form-group col-xs-12" style="margin-top: 20px;">
                                                    <table class="table no-border">
                                                        <tbody>
                                                        <tr>
                                                            <th>Sub Total</th>
                                                            <th class="text-right"> <span id="sub-total"></span> </th>
                                                        </tr>
                                                        <tr>
                                                            <th>VAT </th>
                                                            <th class="text-right"><span id="vat"></span> </th>
                                                        </tr>
                                                        <tr>
                                                            <th>You will be charged</th>
                                                            <th class="text-right"><span id="total"></span> </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>

                                            <button class="btn btn-primary btn-sm nextBtn btn-lg pull-right" type="button" >Proceed</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row setup-content" id="step-2">
                                    <div class="col-md-12">
                                        <div class="col-md-12" id="stk-payment">
                                            <div class="form-group">
                                                <h3>Instructions</h3>
                                                <ul>
                                                    <li>Click on the <strong class="text-danger">PAY NOW</strong> button to generate a payment request on your phone</li>
                                                    <li>Enter your <strong class="text-danger">MPESA PIN</strong> on your phone to complete the payment</li>


                                                    <!-- <li>If you do not know your <strong class="text-danger">SERVICE PIN</strong>, then type in 0 on the payment request on your phone</li>
                                                    <li>Follow the prompts to reset your <strong class="text-danger">SERVICE PIN</strong></li>
                                                    <li>Click the <strong class="text-danger">RETRY</strong> button to generate a new payment request</li> -->
                                                    <li>You will get your receipt from MPESA and an SMS confirmation from iPay</li>
                                                    <li> Didn't get the prompt on your phone? Kindly dial  <strong class="text-danger">*234*1*6#</strong> to force SIM update. For SIM cards  <strong class="text-danger">more than 2 years old</strong> a SIM swap may be necessary </li>

                                                </ul>
                                            </div>
                                            <form action="{{ url('admin/stkSubmit') }}" method="post">
                                                <div class="form-group">
                                                    <label>MPESA Number</label>
                                                    <input type="text" maxlength="12" id="mobile" class="form-control " name="phone_number" required >
                                                    <input type="hidden" name="invoice_id" class="invoice_id">
                                                </div>

                                                <br>
                                                <a href="#" class="btn btn-primary btn-block" id="pay-now" style="-webkit-transition: width 20s;transition: width 20s;" >
                                                    <span><i class="glyphicon glyphicon-refresh spinning"></i></span> PAY NOW</a>

                                            </form>
                                        </div>


                                        <div class="col-xs-12" id="old-payment" style="display: none;">
                                            <ul>
                                                <li>Go to the M-PESA menu on your phone</li>
                                                <li>Select PayBill Option : Enter Business Number: <b>270872</b></li>
                                                <li>Enter <b class="text-danger" id="account"></b> as the Account Number</li>
                                                <li>Enter the <b>EXACT</b> amount (KSh. <b class="text-danger" id="amount"> </b> )</li>
                                                <li>Enter your PIN and then send the money</li>
                                                <li>Complete your transaction on your phone</li>
                                                <li>You will receive a transaction confirmation SMS from MPESA</li>

                                                <li>Then click on the <b>Confirm Payment Done</b> button below</li>
                                            </ul>
                                            <input type="hidden" name="ref_number" class="ref_number">
                                            <input type="hidden" name="amount" class="amount">
                                            <button id="btn" class="btn btn-block btn-primary" onclick="" type="submit"><b>Confirm Payment Done</b></button>

                                            <br>
                                            <br>
                                        </div>
                                        <a href="#" class="text-danger" id="toggle-btn"><span class="glyphicon glyphicon-question-sign"></span> Click here if did not get a prompt on your phone to go to the previous MPESA payment method</a>

                                        <br>
                                        <br>
                                        <div class="col-md-12">
                                            {{--                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>--}}

                                            <button class="btn btn-success btn-sm previousBtn btn-lg pull-left" type="button" >Previous</button>

                                            {{--                                    <button type="submit" class="btn btn-success btn-sm  pull-right" id="finish-btn" >Done</button>--}}
                                        </div>
                                    </div>
                                </div>
                                {{--                    <div class="overlay">--}}
                                {{--                        <i class="fa fa-refresh fa-spin"></i>--}}
                                {{--                    </div>--}}
                            </div>
                            <div class="modal-body" id="loading-modal" style="display:none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success" id="processing">
                                            <p> Please Wait         <span class="fa fa-spinner  fa-spin"></span></p>
                                        </div>

                                        <div class="alert alert-danger" style="display: none" id="sdk-error">
                                            <p><strong>Error!</strong> Please refresh and try again</p>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </form>

            </div>
    </div>

    <script src="{{ asset('assets/plugins/amcharts/amcharts.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/serial.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/pie.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/themes/light.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/plugins/export/export.min.js') }}"
            type="text/javascript"></script>
    <script>
        AmCharts.makeChart("monthly_actual_expected_data", {
            "type": "serial",
            "theme": "light",
            "autoMargins": true,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "fontFamily": 'Open Sans',
            "color": '#888',

            "dataProvider": {!! $monthly_actual_expected_data !!},
            "valueAxes": [{
                "axisAlpha": 0,

            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#370fc6",
                "lineThickness": 4,
                "negativeLineColor": "#0dd102",
                "title": "{{trans_choice('general.actual',1)}}",
                "type": "smoothedLine",
                "valueField": "actual"
            }, {
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#d1655d",
                "lineThickness": 4,
                "negativeLineColor": "#d1cf0d",
                "title": "{{trans_choice('general.expected',2)}}",
                "type": "smoothedLine",
                "valueField": "expected"
            }],
            "categoryField": "month",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0,
                "labelRotation": 30,

            }, "export": {
                "enabled": true,
                "libs": {
                    "path": "{{asset('assets/plugins/amcharts/plugins/export/libs')}}/"
                }
            }, "legend": {
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": false
            },


        });

    </script>
    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"
            type="text/javascript"></script>
    <script>
        var ctx3 = document.getElementById("loan_status_pie").getContext("2d");
        var data3 ={!! $loan_statuses !!};
        var myPieChart = new Chart(ctx3).Pie(data3, {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 0,
            animationSteps: 100,
            tooltipCornerRadius: 0,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            responsive: true,

            legend: {
                display: true,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            }
        });
    </script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ url('smsBalance') }}',
                type: 'GET',
                beforeSend: function(){
                    $("#bal-span").html('...')
                },
                dataType: 'json',
                success: function(data){
                    $("#bal-span").html(data.toFixed(2))
                    if(data == '0'){
                        $('#sms-available').html(0);
                    }else{
                        $('#sms-available').html(Math.floor(data/1.5));
                    }
                }
            });
            // setInterval(function(){
            //     $('.alert').fadeOut();
            //     }, 3000);
        });
    </script>

    <script>
        $('#gross_amount').on('keyup',function(){
            if($(this).val() !== ''){
                let gross = parseFloat($(this).val());
                let vat = gross * 0.14;
                let subtotal = gross - vat;

                $('#total').html(gross);
                $('#vat').html(vat);
                $('#sub-total').html(subtotal);
            }else{
                $('#total').html('');
                $('#vat').html('');
                $('#sub-total').html('');
            }


        })
    </script>

    <script>
        function toggleHide(){
            $('#content-modal').toggle()
            $('#loading-modal').toggle()
        }

        function displayError(){
            $('#processing').toggle();
            $('#sdk-error').toggle()
        }

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');
            allPreviousBtn = $('.previousBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function(){
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("textarea,select,input[type='text'],input[type='url']"),
                    isValid = true;

                // alert(nextStepWizard);
                $(".form-group").removeClass("has-error");
                for(var i=0; i<curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid){
                    nextStepWizard.removeAttr('disabled').trigger('click');
                    saveInvoice($('#gross_amount').val())
                }
            });

            allPreviousBtn.click(function(){
                $('#first').removeAttr('disabled').trigger('click');
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });

        function saveInvoice(gross){
            $.ajax({
                // url: 'https://sms.openpathsolutions.co.ke/api/purchaseCreditsStore',
                url: '{{ url('purchaseCreditsStore') }}',
                type: 'POST',
                dataType: 'json',
                beforeSend: function(){
                    toggleHide()
                },
                data: {
                    'amount': gross,
                },
                success: function(data){
                    // error(data)
                    if(!jQuery.isEmptyObject(data)){
                        toggleHide();
                        $('.amount').val(data.amount);
                        $('#amount').html(data.amount);
                        $('#account').html((data.invoice_number));
                        $('.ref_number').val((data.invoice_number));
                        $('.invoice_id').val((data.id));
                    }else{
                        displayError()
                    }
                }
            });
        }

        $('#toggle-btn').on('click',function(){
            $('#old-payment').toggle(function(){ $('#toggle-btn').show()})
            $('#stk-payment').toggle(function(){ $('#toggle-btn').show()})
            // $('#toggle-btn').toggle(function(){ $(this).text('yeah')})

        })

        $('#pay-now').on('click',function(){
            if($('#mobile').val() !== ''){
                $.ajax({
                    url: '{{ url('stkSubmit') }}',
                    // url: 'https://sms.openpathsolutions.co.ke/api/stkSubmit',
                    dataType: 'json',
                    beforeSend: function(){
                        toggleHide();
                    },
                    type: 'POST',
                    data: {
                        'invoice': $('.invoice_id').val(),
                        'phone': $('#mobile').val()
                    },
                    success: function(data){
                        toggleHide()
                        error(data)

                    }
                });
            }
        });
    </script>
@endsection

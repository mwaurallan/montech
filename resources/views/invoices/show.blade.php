@extends('layouts.master')
@section('title')
    View Invoice
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Invoice </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                <section class="invoice">
                    {{--                <div id="badge">--}}
                    {{--                    <div class="arrow-up"></div>--}}
                    {{--                    <div class="label bg-aqua"></div>--}}
                    {{--                    <div class="arrow-right"></div>--}}
                    {{--                </div>--}}

                    <div class="row invoice-header">
                        <div class="col-xs-7"></div>
                        <div class="col-xs-5">
                            <div id="badge">
                                <div class="arrow-up"></div>
                                @if($invoice->status)
                                    <div class="alert alert-success"><strong>PAID</strong></div>
                                @elseif(!$invoice->status && $invoice->due_date < \Carbon\Carbon::today())
                                    <div class="alert alert-danger "><strong>OVERDUE</strong></div>
                                @else
                                    <div class="alert alert-warning">DUE</div>
                                @endif

                                <div class="arrow-right"></div>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <img src="{{ asset('img/logo.png') }}" class="invoice-logo">
                        </div>
                        <div class="col-xs-5 invoice-company">
                            <address>
                                <strong>Openpath Solutions</strong><br>
                                Westlands Arcade, Rm 216<br>
                                Westlands Nairobi <br>
                                <br>
                                0202088200<br>
                                0722401489<br>
                                info@openpathsolutions.co.ke
                            </address>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-7">
                            Bill To
                            <address>
                                <strong>{{ \App\Models\Setting::where('setting_key','company_name')->first()->setting_value }}</strong><br>
                                {{ \App\Models\Setting::where('setting_key','company_email')->first()->setting_value }}<br>
                                {{ \App\Models\Setting::where('setting_key','company_address')->first()->setting_value }}<br>
{{--                                {{ $invoice->client->location }}<br>--}}
                                <br>

                            </address>
                        </div>
                        <div class="col-xs-5">
                            <div class="table-responsive">
                                <table class="table no-border">
                                    <tbody>
                                    <tr>
                                        <th>Invoice Number:</th>
                                        <td class="text-right">{{ $invoice->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Date:</th>
                                        <td class="text-right">{{ \Carbon\Carbon::parse($invoice->date)->toFormattedDateString() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Due:</th>
                                        <td class="text-right">{{ \Carbon\Carbon::parse($invoice->due_date)->toFormattedDateString() }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th>Particulars</th>
{{--                                    <th class="text-center">leases</th>--}}
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                <tr>
                                    <td>
                                        Monthly Support Fee
                                                                            <br><small>SKU: 111</small>
                                    </td>
{{--                                    <td class="text-center">{{ $invoice->leases }}</td>--}}
                                    <td class="text-right"> {{ number_format($invoice->amount,2) }}</td>
                                    <td class="text-right">KES {{ number_format($invoice->amount,2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="row">
                        <div class="col-xs-7">
                        </div>
                        <div class="col-xs-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td class="text-right">KES {{ number_format($invoice->amount,2) }}</td>
                                    </tr>
                                    {{--                                <tr>--}}
                                    {{--                                    <th>Tax Exempt:</th>--}}
                                    {{--                                    <td class="text-right">KES0.00</td>--}}
                                    {{--                                </tr>--}}
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right">KES {{ number_format($invoice->amount,2)  }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <p class="lead">Notes</p>

                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                Pay through MPESA
                                Pay Bill: 270872 <br>
                                Account: Your Company Name
                            </p>
                        </div>
                    </div>

                    <div class="box-footer row no-print">
                        <div class="col-md-12">

                            <a onclick="window.print()" target="_blank" class="btn btn-success pull-right">
                                <i class="fa fa-print"></i>&nbsp; Print
                            </a>
                        </div>
                    </div>
                </section>
             </div>
    </div>
@endsection


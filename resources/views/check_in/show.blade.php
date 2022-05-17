@extends('layouts.master')
@section('title')
{{--    {{$product->name}}--}}
    Show Check In
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                @include('report.includes.report-header')
                <div class="panel-heading hidden-print">
{{--                    <h3 class="panel-title">Show Check in </h3>--}}

                    <div class="heading-elements">

                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Cost Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($checkIns))
                                @foreach($checkIns as $product)
                                    <tr>
                                        <td> {{ $product->product->name }}</td>
                                        <td> {{ $product->qty }}</td>
                                        <td>KSH {{ $product->unit_cost }}</td>
                                        <td>KSH {{ $product->total_cost }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <th>Total</th>
                                        <th>KSH {{ number_format($checkIns->sum('total_cost'),2) }}</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-11 hidden-print">
                        <br>
                        <br>
                        <button class="btn  btn-success hidden-print pull-right" style="margin-right: 10px" onclick="window.print()">Normal Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer-scripts')
    <script src="{{ asset('assets/plugins/datatable/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/media/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/extensions/Buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/extensions/Buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatable/extensions/Buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $('#data-table').DataTable();
    </script>
@endsection

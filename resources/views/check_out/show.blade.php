@extends('layouts.master')
@section('title')
    {{--    {{$product->name}}--}}
    Show Check Out
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                @include('report.includes.report-header')
                <div class="panel-heading hidden-print  ">
{{--                    <h3 class="panel-title">Show Check Out </h3>--}}

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
                            @if(count($checkOuts))
                                @foreach($checkOuts as $product)
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
                                    <th>KSH {{ number_format($checkOuts->sum('total_cost'),2) }}</th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-11 hidden-print">
                        <br>
                        <br>
                        <button class="btn btn-primary pull-right" onclick="PrintTicket()">Thermal Print</button>
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



    <script type="text/javascript" src="{{ asset('qz/js/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qz/js/dependencies/sha-256.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qz/js/qz-tray.js') }}"></script>
    <script>
        function PrintTicket() {
            var data = [
                // { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: { language: "ESCPOS", dotDensity: 'double' } },
                '\x1B' + '\x40',          // init
                '\x1B' + '\x61' + '\x31', // center align
                'Narugi Sacco' + '\x0A',
                // '\x0A',                   // line break
                'narugisacco@gmail.com' + '\x0A',     // text and line break
                // '\x0A',                   // line break
                '\x0A',                   // line break
                'PURCHASE RECEIPT #{{ $product_check_out->id }}' + '\x0A',

                // '\x0A',                   // line break
                '\x1B' + '\x61' + '\x30', // left align
                '---------------------------------------------' + '\x0A',
                'Item       Quantity    Price   Total' + '\x0A',
                @foreach($checkOuts as $prod)
                    '{{ $prod->product->name }}     {{$prod->qty}}  {{ number_format($prod->unit_cost,2) }}  {{ number_format($prod->total_cost,2) }}' + '\x0A',
                    @endforeach
               '\x0A',                   // line break
                '\x0A',                   // line break

                '\x1B' + '\x45' + '\x0D', // bold on
                'Total                              {{ number_format($checkOuts->sum('total_cost',2)) }}' + '\x0A',
                // 'Here\'s some bold text!',
                // '\x0A',
                '\x1B' + '\x45' + '\x0A', // bold off
                // '\x1D' + '\x21' + '\x11', // double font size
                // 'Here\'s large text!',
                // '\x0A',
                // '\x1D' + '\x21' + '\x00', // standard font size
                // '\x1B' + '\x61' + '\x32', // right align
                // '\x1B' + '\x21' + '\x30', // em mode on
                // 'DRINK ME',
                // '\x1B' + '\x21' + '\x0A' + '\x1B' + '\x45' + '\x0A', // em mode off
                // '\x0A' + '\x0A',
                // '\x1B' + '\x61' + '\x30', // left align
                // '------------------------------------------' + '\x0A',
                // '\x1B' + '\x4D' + '\x31', // small text
                // 'EAT ME' + '\x0A',
                // '\x1B' + '\x4D' + '\x30', // normal text
                '---------------------------------------------' + '\x0A',
                'Served By: {{ Sentinel::getUser()->name  }}'+ '\x0A',
                '{{ \Carbon\Carbon::now()->toDayDateTimeString() }}'+ '\x0A',
                '\x1B' + '\x61' + '\x30', // left align
                '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A',
                '\x1B' + '\x69',          // cut paper (old syntax)
// '\x1D' + '\x56'  + '\x00' // full cut (new syntax)
// '\x1D' + '\x56'  + '\x30' // full cut (new syntax)
// '\x1D' + '\x56'  + '\x01' // partial cut (new syntax)
// '\x1D' + '\x56'  + '\x31' // partial cut (new syntax)
                '\x10' + '\x14' + '\x01' + '\x00' + '\x05',  // Generate Pulse to kick-out cash drawer**
                                                             // **for legacy drawer cable CD-005A.  Research before using.
                                                             // see also http://keyhut.com/popopen4.htm
            ];


            qz.websocket.connect().then(function() {
                var config = qz.configs.create("usb1");
                qz.print(config, data);
                return true;
            }).catch(function(err) { alert(err); });

        }
    </script>
@endsection

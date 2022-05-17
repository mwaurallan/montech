@extends('layouts.customer')

@section('pageTitle', 'My Savings')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">
            {{--<a class="btn btn-success pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>--}}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="box box-success">
            <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($savings))
                            @foreach($savings as $saving)
                                <tr>
                                    <td> {{ \Carbon\Carbon::parse($saving->date)->toFormattedDateString() }}</td>
                                    <td> {{ number_format($saving->amount,2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
                                <th>{{ number_format($savings->sum('amount'),2) }}</th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('a#savings').parent('li').addClass('active').parent('ul').parent().addClass('active');
    </script>
@endpush
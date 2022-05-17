@extends('layouts.master')
@section('title')Sent SMSs
@endsection
@section('content')
        <!-- Default box -->
<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">Sent SMSs</h6>

        <div class="heading-elements">
            @if(Sentinel::hasAccess('communication.create'))
                <a href="{{ url('communication/sms/create') }}"
                   class="btn btn-info btn-sm">Send SMSs</a>
            @endif
        </div>
    </div>
    <div class="panel-body table-responsive">
        @include('communication.table')
{{--        <table id="data-table" class="table table-bordered table-condensed table-hover">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>{{trans_choice('general.send_by',1)}}</th>--}}
{{--                <th>{{trans_choice('general.to',1)}}</th>--}}
{{--                <th>{{trans_choice('general.recipient',2)}}</th>--}}
{{--                <th>{{trans_choice('general.message',1)}}</th>--}}
{{--                <th>{{trans_choice('general.gateway',1)}}</th>--}}
{{--                <th>{{trans_choice('general.date',1)}}</th>--}}
{{--                <th>{{ trans_choice('general.action',1) }}</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($data as $key)--}}
{{--                <tr>--}}
{{--                    <td>--}}
{{--                        @if(!empty($key->user))--}}
{{--                            <a href="{{url('user/'.$key->user_id.'/show')}}">{{$key->user->first_name}} {{$key->user->last_name}}</a>--}}
{{--                        @else--}}

{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td>{{$key->send_to}}</td>--}}
{{--                    <td>{{$key->recipients}}</td>--}}
{{--                    <td>{!!$key->message!!}</td>--}}
{{--                    <td>{!!$key->gateway!!}</td>--}}
{{--                    <td>{{$key->created_at}}</td>--}}
{{--                    <td>--}}
{{--                        @if(Sentinel::hasAccess('communication.delete'))--}}
{{--                            <a href="{{ url('communication/sms/'.$key->id.'/delete') }}"--}}
{{--                               class="delete"><i--}}
{{--                                        class="fa fa-trash"></i> </a>--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')
@endsection

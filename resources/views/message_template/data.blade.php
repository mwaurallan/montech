@extends('layouts.master')
@section('title')Sms Templates
@endsection

@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Sms Templates</h6>

            <div class="heading-elements">
                <a href="{{ url('template/create') }}"
                   class="btn btn-info btn-sm">{{trans_choice('general.add',1)}} Template</a>
            </div>
        </div>
        <div class="panel-body">
            <table id="" class="table table-striped table-condensed table-hover basic-datatable">
                <thead>
                <tr>
                    <th>Event</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>{{ trans_choice('general.action',1) }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key)
                    <tr>
                        <td>{{ $key->event }}</td>
                        <td>{{ $key->message }}</td>

                        <td>
                            @if($key->status==1)
                                {{trans_choice('general.active',1)}}
                            @else
                                {{trans_choice('general.inactive',1)}}
                            @endif
                        </td>
                        <td>
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li><a href="{{ url('template/'.$key->id.'/edit') }}"><i
                                                        class="fa fa-edit"></i> {{ trans('general.edit') }} </a></li>
                                        <li><a href="{{ url('template/'.$key->id.'/delete') }}"
                                               class="delete"><i
                                                        class="fa fa-trash"></i> {{ trans('general.delete') }} </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.box -->
@endsection
@section('footer-scripts')

@endsection

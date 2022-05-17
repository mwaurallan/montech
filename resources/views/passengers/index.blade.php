@extends('layouts.master')
@section('title')
    Passengers
@endsection
@section('content')
        <div class="panel panel-white">
                <div class="panel-heading">
                    <h6 class="panel-title">Passengers</h6>
                    <div class="heading-elements">
                        @if(Sentinel::hasAccess('passengers.create'))
                            <a href="{{ route('passengers.create') }}"
                               class="btn btn-info btn-sm">Add New</a>
                        @endif
                    </div>
                </div>
                <div class="panel-body ">
                    <div class="table-responsive">
                        @include('passengers.table')
                    </div>
                </div>
                <!-- /.panel-body -->
        </div>
@endsection


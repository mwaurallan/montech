@extends('layouts.master')
@section('title')
    View Payment
@endsection
@section('content')

<div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Show Payment </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="panel-body">
                   @include('payments.show_fields')
              <a href="{{ route('payments.index') }}" class="btn btn-default">Back</a>

             </div>
    </div>
@endsection


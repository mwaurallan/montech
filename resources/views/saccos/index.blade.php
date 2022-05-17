@extends('layouts.master')
 @section("title",'Saccos')
@section('content')

    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">'Saccos'</h6>
            <div class="heading-elements">
                <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>
            </div>
        </div>
        <div class="panel-body ">
            @include('saccos.table')
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.box -->

    <div class="modal fade" id="create-modal" role="dialog">
        {!! Form::open(['route' => 'saccos.store']) !!}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Create Sacco</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('saccos.fields')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="edit-modal" role="dialog">
        <form method="post" id="edit-form">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Edit Sacco</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('saccos.fields')
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="editDetails" value="{{ url("/saccos") }}">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
    </div>

    {{--delete modal--}}
    <div class="modal fade" id="delete-modal" role="dialog">
        <form id="delete-form" method="post">
            <input name="_method" type="hidden" value="DELETE">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Sacco</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Sacco?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
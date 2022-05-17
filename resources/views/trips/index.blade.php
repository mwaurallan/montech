@extends('layouts.master')
@section('title')
    Trips
@endsection
@section('content')
    <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Trips</h6>
                <div class="heading-elements">
                    @if(Sentinel::hasAccess('trips.create'))
                        <a href="{{ route('trips.create') }}"
                           class="btn btn-info btn-sm">Add New</a>
                    @endif
                </div>
            </div>
            <div class="panel-body ">
                <div class="table-responsive">
                    @include('trips.table')
                </div>
            </div>
            <!-- /.panel-body -->
        </div>

    <div id="payment-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Payment</h4>
                </div>
                <form action="" method="post" id="payment-form">
                    @csrf
                <div class="modal-body">
                    <div id="payment-details-div">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" autocomplete="off" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" class="form-control" name="phone_number" autocomplete="off" required>
                        </div>
                        <input type="hidden" name="trip_id" id="trip_id">
                        <div class="form-group">
                            <button class="btn btn-success" id="submit-payment">Submit Payment</button>
                        </div>
                    </div>
                    <div id="alert-div">
                        <div class="alert alert-success">
                            <strong>Submitting payment request,please wait</strong>   <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $('body').on('click','#make-p-btn',function(){
                let tId = $(this).attr('t-id');
                $('#trip_id').val(tId)
            });

            $('#payment-form').on('submit',function(e){
                e.preventDefault();
                $.ajax({
                    url: '{{ url('api/stkSubmit') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#payment-form').serialize()
                })
            })
        })
    </script>
@endpush


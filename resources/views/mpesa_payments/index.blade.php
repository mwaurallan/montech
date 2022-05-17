@extends('layouts.master')
@section('title')
Mpesa Payments
@endsection
@section('content')
<div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Mpesa Payments</h6>
            <div class="heading-elements">
                @if(Sentinel::hasAccess('mpesaPayments.create'))
                    <a href="{{ route('mpesaPayments.create') }}"
                       class="btn btn-info btn-sm">Add New</a>
                @endif
            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                @include('mpesa_payments.table')
            </div>
        </div>
        <!-- /.panel-body -->
</div>


<div class="modal fade" id="edit-modal" role="dialog">
    <form method="post" action="{{ url('updateMpesa') }}" id="edit-form">
        {{ csrf_field() }}
{{--        <input name="_method" type="hidden" value="PATCH">--}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Payment</h4>
                </div>
                <div class="modal-body">
{{--                    <div class="row">--}}
                       <div class="form-group">
                           <label>Member</label>
                           <select name="borrower_id" class="form-control select2" required>
                               <option value="">Select Member</option>
                               @if(count($members))
                                   @foreach($members as $member)
                                       <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                   @endforeach
                                   @endif
                           </select>
                       </div>
                    <input name="payment_id" type="hidden" id="payment-id">
{{--                    </div>--}}
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="editDetails" value="{{ url("/payments") }}">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
</div>
@endsection
@push('js')
    <script>
       $('body').on('click','.edit-common',function (){
           let id = $(this).attr('e-id');
            $('#payment-id').val(id)
       })
    </script>
    @endpush


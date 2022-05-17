@extends('layouts.master')
@section('title')
    {{trans_choice('general.disburse',1)}} {{trans_choice('general.loan',1)}}
@endsection
@section('content')
    {{--Modal--}}
    <!-- Basic modal -->
    <div id="loan-disbursement-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Disburse Loan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form" method="post" id="loan-disbursement-form" action="{{route("loan.approve", ["id"=>$loan->id])}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="approved-amount" class="control-label">Amount Disbursed</label>
                            <input class="form-control" value="{{$loan->principal}}" required type="number" step="0.10" name="approved_amount" id="approved-amount">
                        </div>
                        <div class="form-group">
                            <label for="approved-notes" class="control-label">Notes</label>
                            <textarea class="form-control" name="approved_notes" id="approved-notes"></textarea>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" form="loan-disbursement-form" class="btn bg-primary">Disburse Loan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic modal -->
@endsection
@section('footer-scripts')
    <script>
        $(document).ready(function () {
            $("#loan-disbursement-modal").modal("show");
        });
    </script>
@endsection

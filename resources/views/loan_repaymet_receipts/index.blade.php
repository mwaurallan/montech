@extends('layouts.master')

@section('title')
    Loan Repayment Receipts
@endsection


@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> Loan Repaymet Receipts </h6>

            <div class="heading-elements">
                @if(Sentinel::hasAccess('loan_repaymet_receipts.create'))
                    <a href="{{ url('loan_repaymet_receipts/create') }}"
                       class="btn btn-info btn-sm"> Add Loan Repaymet Receipts </a>
                @endif
            </div>
        </div>

        <div class="panel-body ">
                 <div class="table-responsive">
                    @include('loan_repaymet_receipts.table')
                </div>
        </div>
    </div>

    <div class="modal fade" id="process-modal" role="dialog">
        {!! Form::open(['url' => 'loan/process-loan-repayment']) !!}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Process Loan Repayment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="">Select Loan</label>
                            <select name="loan_id" class="form-control select2" required id="loan_id">
                                <option value="">Select Loan</option>
                            </select>
                        </div>
                        <input type="hidden" name="repayment_id" id="repayment_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Process</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        {!! Form::close() !!}
    </div>

@endsection

@section('footer-scripts')
    <script>
        $(document).on('click','.process-btn',function(){
            let borrowerId = $(this).attr('b-id');
            let receiptId = $(this).attr('receipt-id');
            $('#repayment_id').val(receiptId);

            let html = '<option value="">Select Loan</option>';
            $.ajax({
                url: '{{ url('loan/getMemberLoans') }}'+ '/'+ borrowerId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    if(data.length){
                        for (let i =0; i<data.length; i++){
                            html += '<option value="'+data[i].id+'"> '+ data[i].id+' - '+data[i].loan_product.name+'</option>';
                        }
                        $('#loan_id').html(html);
                    }
                }

            })
        })
    </script>
    @endsection


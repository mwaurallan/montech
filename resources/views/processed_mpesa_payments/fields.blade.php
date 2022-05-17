<!-- Payment Mode Field -->
<div class="form-group">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    {!! Form::text('payment_mode', null, ['class' => 'form-control']) !!}
</div>


<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    {!! Form::text('ref_number', null, ['class' => 'form-control']) !!}
</div>


<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>


<!-- Paybill Field -->
<div class="form-group">
    {!! Form::label('paybill', 'Paybill:') !!}
    {!! Form::text('paybill', null, ['class' => 'form-control']) !!}
</div>


<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>


<!-- Bill Ref Number Field -->
<div class="form-group">
    {!! Form::label('bill_ref_number', 'Bill Ref Number:') !!}
    {!! Form::text('bill_ref_number', null, ['class' => 'form-control']) !!}
</div>


<!-- Trans Id Field -->
<div class="form-group">
    {!! Form::label('trans_id', 'Trans Id:') !!}
    {!! Form::text('trans_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Trans Time Field -->
<div class="form-group">
    {!! Form::label('trans_time', 'Trans Time:') !!}
    {!! Form::date('trans_time', null, ['class' => 'form-control','id'=>'trans_time']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#trans_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush


<!-- First Name Field -->
<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>


<!-- Middle Name Field -->
<div class="form-group">
    {!! Form::label('middle_name', 'Middle Name:') !!}
    {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
</div>


<!-- Last Name Field -->
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>


<!-- Received On Field -->
<div class="form-group">
    {!! Form::label('received_on', 'Received On:') !!}
    {!! Form::date('received_on', null, ['class' => 'form-control','id'=>'received_on']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#received_on').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush


<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('status', 0) !!}
        {!! Form::checkbox('status', '1', null) !!}
    </label>
</div>


<!-- Borrower Id Field -->
<div class="form-group">
    {!! Form::label('borrower_id', 'Borrower Id:') !!}
    {!! Form::number('borrower_id', null, ['class' => 'form-control']) !!}
</div>


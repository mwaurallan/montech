<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    <p>{{ $invoicePayment->ref_number }}</p>
</div>

<!-- Date Paid Field -->
<div class="form-group">
    {!! Form::label('date_paid', 'Date Paid:') !!}
    <p>{{ $invoicePayment->date_paid }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $invoicePayment->amount }}</p>
</div>

<!-- Sacco Id Field -->
<div class="form-group">
    {!! Form::label('sacco_id', 'Sacco Id:') !!}
    <p>{{ $invoicePayment->sacco_id }}</p>
</div>


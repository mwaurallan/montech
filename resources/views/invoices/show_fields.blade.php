<!-- Sacco Id Field -->
<div class="form-group">
    {!! Form::label('sacco_id', 'Sacco Id:') !!}
    <p>{{ $invoice->sacco_id }}</p>
</div>

<!-- Invoice Date Field -->
<div class="form-group">
    {!! Form::label('invoice_date', 'Invoice Date:') !!}
    <p>{{ $invoice->invoice_date }}</p>
</div>

<!-- Due Date Field -->
<div class="form-group">
    {!! Form::label('due_date', 'Due Date:') !!}
    <p>{{ $invoice->due_date }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $invoice->amount }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $invoice->status }}</p>
</div>


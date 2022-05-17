<!-- Payment Mode Field -->
<div class="form-group">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    <p>{{ $payment->payment_mode }}</p>
</div>

<!-- Source Field -->
<div class="form-group">
    {!! Form::label('source', 'Source:') !!}
    <p>{{ $payment->source }}</p>
</div>

<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    <p>{{ $payment->ref_number }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $payment->amount }}</p>
</div>

<!-- Paybill Field -->
<div class="form-group">
    {!! Form::label('paybill', 'Paybill:') !!}
    <p>{{ $payment->paybill }}</p>
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $payment->phone_number }}</p>
</div>

<!-- Bill Ref Number Field -->
<div class="form-group">
    {!! Form::label('bill_ref_number', 'Bill Ref Number:') !!}
    <p>{{ $payment->bill_ref_number }}</p>
</div>

<!-- Trans Id Field -->
<div class="form-group">
    {!! Form::label('trans_id', 'Trans Id:') !!}
    <p>{{ $payment->trans_id }}</p>
</div>

<!-- Trans Time Field -->
<div class="form-group">
    {!! Form::label('trans_time', 'Trans Time:') !!}
    <p>{{ $payment->trans_time }}</p>
</div>

<!-- First Name Field -->
<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{{ $payment->first_name }}</p>
</div>

<!-- Middle Name Field -->
<div class="form-group">
    {!! Form::label('middle_name', 'Middle Name:') !!}
    <p>{{ $payment->middle_name }}</p>
</div>

<!-- Last Name Field -->
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{{ $payment->last_name }}</p>
</div>

<!-- Received On Field -->
<div class="form-group">
    {!! Form::label('received_on', 'Received On:') !!}
    <p>{{ $payment->received_on }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $payment->status }}</p>
</div>


<!-- Payment Mode Field -->
<div class="form-group">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    <p>{{ $mpesaPayment->payment_mode }}</p>
</div>

<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    <p>{{ $mpesaPayment->ref_number }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $mpesaPayment->amount }}</p>
</div>

<!-- Paybill Field -->
<div class="form-group">
    {!! Form::label('paybill', 'Paybill:') !!}
    <p>{{ $mpesaPayment->paybill }}</p>
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $mpesaPayment->phone_number }}</p>
</div>

<!-- Bill Ref Number Field -->
<div class="form-group">
    {!! Form::label('bill_ref_number', 'Bill Ref Number:') !!}
    <p>{{ $mpesaPayment->bill_ref_number }}</p>
</div>

<!-- Trans Id Field -->
<div class="form-group">
    {!! Form::label('trans_id', 'Trans Id:') !!}
    <p>{{ $mpesaPayment->trans_id }}</p>
</div>

<!-- Trans Time Field -->
<div class="form-group">
    {!! Form::label('trans_time', 'Trans Time:') !!}
    <p>{{ $mpesaPayment->trans_time }}</p>
</div>

<!-- First Name Field -->
<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{{ $mpesaPayment->first_name }}</p>
</div>

<!-- Middle Name Field -->
<div class="form-group">
    {!! Form::label('middle_name', 'Middle Name:') !!}
    <p>{{ $mpesaPayment->middle_name }}</p>
</div>

<!-- Last Name Field -->
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{{ $mpesaPayment->last_name }}</p>
</div>

<!-- Received On Field -->
<div class="form-group">
    {!! Form::label('received_on', 'Received On:') !!}
    <p>{{ $mpesaPayment->received_on }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $mpesaPayment->status }}</p>
</div>


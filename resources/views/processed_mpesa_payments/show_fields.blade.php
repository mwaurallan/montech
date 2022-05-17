<!-- Payment Mode Field -->
<div class="form-group">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    <p>{{ $processedMpesaPayment->payment_mode }}</p>
</div>

<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    <p>{{ $processedMpesaPayment->ref_number }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $processedMpesaPayment->amount }}</p>
</div>

<!-- Paybill Field -->
<div class="form-group">
    {!! Form::label('paybill', 'Paybill:') !!}
    <p>{{ $processedMpesaPayment->paybill }}</p>
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $processedMpesaPayment->phone_number }}</p>
</div>

<!-- Bill Ref Number Field -->
<div class="form-group">
    {!! Form::label('bill_ref_number', 'Bill Ref Number:') !!}
    <p>{{ $processedMpesaPayment->bill_ref_number }}</p>
</div>

<!-- Trans Id Field -->
<div class="form-group">
    {!! Form::label('trans_id', 'Trans Id:') !!}
    <p>{{ $processedMpesaPayment->trans_id }}</p>
</div>

<!-- Trans Time Field -->
<div class="form-group">
    {!! Form::label('trans_time', 'Trans Time:') !!}
    <p>{{ $processedMpesaPayment->trans_time }}</p>
</div>

<!-- First Name Field -->
<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{{ $processedMpesaPayment->first_name }}</p>
</div>

<!-- Middle Name Field -->
<div class="form-group">
    {!! Form::label('middle_name', 'Middle Name:') !!}
    <p>{{ $processedMpesaPayment->middle_name }}</p>
</div>

<!-- Last Name Field -->
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{{ $processedMpesaPayment->last_name }}</p>
</div>

<!-- Received On Field -->
<div class="form-group">
    {!! Form::label('received_on', 'Received On:') !!}
    <p>{{ $processedMpesaPayment->received_on }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $processedMpesaPayment->status }}</p>
</div>

<!-- Borrower Id Field -->
<div class="form-group">
    {!! Form::label('borrower_id', 'Borrower Id:') !!}
    <p>{{ $processedMpesaPayment->borrower_id }}</p>
</div>


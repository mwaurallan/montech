<!-- Trip Id Field -->
<div class="form-group">
    {!! Form::label('trip_id', 'Trip Id:') !!}
    <p>{{ $tripPayment->trip_id }}</p>
</div>

<!-- Payment Id Field -->
<div class="form-group">
    {!! Form::label('payment_id', 'Payment Id:') !!}
    <p>{{ $tripPayment->payment_id }}</p>
</div>

<!-- Passenger Id Field -->
<div class="form-group">
    {!! Form::label('passenger_id', 'Passenger Id:') !!}
    <p>{{ $tripPayment->passenger_id }}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $tripPayment->date }}</p>
</div>


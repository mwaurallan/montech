<!-- Member Vehicle Id Field -->
<div class="form-group">
    {!! Form::label('member_vehicle_id', 'Member Vehicle Id:') !!}
    <p>{{ $trip->member_vehicle_id }}</p>
</div>

<!-- From Field -->
<div class="form-group">
    {!! Form::label('from', 'From:') !!}
    <p>{{ $trip->from }}</p>
</div>

<!-- To Field -->
<div class="form-group">
    {!! Form::label('to', 'To:') !!}
    <p>{{ $trip->to }}</p>
</div>

<!-- Driver Field -->
<div class="form-group">
    {!! Form::label('driver', 'Driver:') !!}
    <p>{{ $trip->driver }}</p>
</div>

<!-- Conductor Field -->
<div class="form-group">
    {!! Form::label('conductor', 'Conductor:') !!}
    <p>{{ $trip->conductor }}</p>
</div>


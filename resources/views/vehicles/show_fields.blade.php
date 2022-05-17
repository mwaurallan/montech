<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $vehicle->id !!}</p>
</div>

<!-- Vehicle Field -->
<div class="form-group">
    {!! Form::label('vehicle', 'Vehicle:') !!}
    <p>{!! $vehicle->vehicle !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $vehicle->status !!}</p>
</div>

<!-- Sacco Id Field -->
<div class="form-group">
    {!! Form::label('sacco_id', 'Sacco Id:') !!}
    <p>{!! $vehicle->sacco_id !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $vehicle->deleted_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $vehicle->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $vehicle->updated_at !!}</p>
</div>


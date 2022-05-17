<!-- Member Vehicle Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('member_vehicle_id', 'Vehicle:') !!}
    <select name="member_vehicle_id" class="form-control select2">
        <option value="">Select vehicle</option>
        @if(count($vehicles))
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" {{ ($vehicle->id == isset($trip)? $trip->member_vehicle_id: '')? 'selected' : ''}}> {{ $vehicle->vehicle->vehicle }}</option>
            @endforeach
                @endif
    </select>
</div>


<!-- From Field -->
<div class="form-group col-sm-12">
    {!! Form::label('from', 'From:') !!}
    {!! Form::text('from', null, ['class' => 'form-control']) !!}
</div>


<!-- To Field -->
<div class="form-group col-sm-12">
    {!! Form::label('to', 'To:') !!}
    {!! Form::text('to', null, ['class' => 'form-control']) !!}
</div>


{{--<!-- Driver Field -->--}}
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('driver', 'Driver:') !!}--}}
{{--    {!! Form::text('driver', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}


{{--<!-- Conductor Field -->--}}
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('conductor', 'Conductor:') !!}--}}
{{--    {!! Form::text('conductor', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}



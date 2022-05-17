<!-- Member Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('member_id', 'Member :') !!}
    <select name="member_id" class="form-control select2" required>
        <option value="">Select Member</option>
    @if(count($members))
        @foreach($members as $member)
            <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Vehicle Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('vehicle_id', 'Vehicle :') !!}
    <select name="vehicle_id" class="form-control select2" required>
        <option value="">Select Vehicle</option>
        @if(count($vehicles))
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle }} </option>
            @endforeach
        @endif
    </select>
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">InActive</option>
    </select>
</div>



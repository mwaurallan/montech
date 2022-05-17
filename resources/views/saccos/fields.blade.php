<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Sacco Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('admin_first_name', 'Admin First Name:') !!}
    {!! Form::text('admin_first_name', null, ['class' => 'form-control','required']) !!}
</div>


<div class="form-group col-sm-12">
    {!! Form::label('admin_last_name', 'Admin Last Name:') !!}
    {!! Form::text('admin_last_name', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('admin_email', 'Admin Email:') !!}
    {!! Form::email('admin_email', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('admin_address', 'Admin Address:') !!}
    {!! Form::text('admin_address', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('admin_phone', 'Admin Phone:') !!}
    {!! Form::text('admin_phone', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('gender', 'Gender:') !!}
    <select name="gender" class="form-control">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
</div>





<!-- Trip Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('trip_id', 'Trip Id:') !!}
    {!! Form::number('trip_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Payment Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('payment_id', 'Payment Id:') !!}
    {!! Form::number('payment_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Passenger Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('passenger_id', 'Passenger Id:') !!}
    {!! Form::number('passenger_id', null, ['class' => 'form-control']) !!}
</div>


<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', null, ['class' => 'form-control','id'=>'date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush


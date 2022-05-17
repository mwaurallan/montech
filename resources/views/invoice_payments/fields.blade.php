<!-- Ref Number Field -->
<div class="form-group">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    {!! Form::text('ref_number', null, ['class' => 'form-control']) !!}
</div>


<!-- Date Paid Field -->
<div class="form-group">
    {!! Form::label('date_paid', 'Date Paid:') !!}
    {!! Form::date('date_paid', null, ['class' => 'form-control','id'=>'date_paid']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_paid').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush


<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>


{{--<!-- Sacco Id Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('sacco_id', 'Sacco Id:') !!}--}}
{{--    {!! Form::number('sacco_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}


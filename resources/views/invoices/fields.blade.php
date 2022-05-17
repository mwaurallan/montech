{{--<!-- Sacco Id Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('sacco_id', 'Sacco Id:') !!}--}}
{{--    {!! Form::number('sacco_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}


<!-- Invoice Date Field -->
<div class="form-group">
    {!! Form::label('invoice_date', 'Invoice Date:') !!}
    {!! Form::date('invoice_date', null, ['class' => 'form-control','id'=>'invoice_date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#invoice_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush


<!-- Due Date Field -->
<div class="form-group">
    {!! Form::label('due_date', 'Due Date:') !!}
    {!! Form::date('due_date', null, ['class' => 'form-control','id'=>'due_date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#due_date').datetimepicker({
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


{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('status', 'Status:') !!}--}}
{{--    <label class="checkbox-inline">--}}
{{--        {!! Form::hidden('status', 0) !!}--}}
{{--        {!! Form::checkbox('status', '1', null) !!}--}}
{{--    </label>--}}
{{--</div>--}}


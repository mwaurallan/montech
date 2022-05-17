{{--<div class="form-group">--}}
{{--    {!! Form::label('type',trans_choice('general.type',1),array('class'=>'col-sm-3 control-label')) !!}--}}
{{--    <div class="col-sm-12">--}}
{{--        {!! Form::select('type',array('deposit'=>trans_choice('general.deposit',1),'withdrawal'=>trans_choice('general.withdrawal',1),'interest'=>trans_choice('general.interest',1),'bank_fees'=>trans_choice('general.charge',1)),null, array('class' => 'form-control','required'=>'','id'=>'type')) !!}--}}
{{--    </div>--}}
{{--</div>--}}

        <div class="form-group col-sm-12">
            <label>Vehicle</label>
            <div class="">
                <select name="vehicle" class="form-control select2" required id="vehicle_id">
                    <option value="">Select member/vehicle</option>
                    @if(count($vehicles))
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->member->first_name }}  {{ $vehicle->member->last_name }} - {{ $vehicle->vehicle->vehicle }}</option>
                        @endforeach
                        @endif
                </select>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label>Saving Account</label>
            <div class="">
                <select name="saving_account" class="form-control select2" required id="saving-account">
                    <option value="">Select saving account</option>

                </select>
            </div>
        </div>
        <div class="form-group col-sm-12">
            {!! Form::label('payment_method_id',trans_choice('general.payment',1).' '.trans_choice('general.method',1),array('class'=>'col-sm-3 control-label')) !!}
            <div class="">
                {!! Form::select('payment_method_id',$repayment_methods,null, array('class' => ' form-control','required'=>'required','id'=>'payment_method_id')) !!}
            </div>
        </div>
<div class="form-group col-sm-12">
    {!! Form::label('amount',trans_choice('general.amount',1),array('class'=>'col-sm-3 control-label')) !!}
    <div class="">
        {!! Form::number('amount',null, array('class' => 'form-control', 'placeholder'=>"Number or decimal only",'required'=>'required','id'=>'amount', 'autocomplete'=>'off')) !!}
    </div>
</div>

<div class="form-groupcol-sm-12 ">
    {!! Form::label('receipt',trans_choice('general.receipt',1),array('class'=>'col-sm-3 control-label')) !!}
    <div class="">
        {!! Form::text('receipt',null, array('class' => 'form-control', 'placeholder'=>"",''=>'required','id'=>'receipt', 'autocomplete'=>'off')) !!}
    </div>
</div>
{{--<div class="form-group">--}}
{{--    {!! Form::label('date',trans_choice('general.date',1),array('class'=>'col-sm-3 control-label')) !!}--}}
{{--    <div class="col-sm-12">--}}
{{--        {!! Form::text('date',date("Y-m-d"), array('class' => 'form-control date-picker', 'placeholder'=>"",'required'=>'required','id'=>'date')) !!}--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('time',trans_choice('general.time',1),array('class'=>'col-sm-3 control-label')) !!}--}}
{{--    <div class="col-sm-12">--}}
{{--        {!! Form::text('time',date("H:i"), array('class' => 'form-control time-picker', 'placeholder'=>'','required'=>'','id'=>'time')) !!}--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-group col-sm-12">
    {!! Form::label('notes',trans_choice('general.description',1),array('class'=>'col-sm-3 control-label')) !!}
    <div class="">
        {!! Form::textarea('notes',null, array('class' => 'form-control', 'rows'=>"4",'id'=>'notes')) !!}
    </div>
</div>
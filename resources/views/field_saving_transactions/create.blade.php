@extends('layouts.master')

@section('title')
    Book New Receipt
@endsection

@section('css')
    <style >
        .form-control {
            color: #76838f;
            background-color: #fff;
            background-image: none;
            border: 1px solid #e4eaec
        }

        .form-control.focus,.form-control:focus {
            border-color: #62a8ea;
            box-shadow: none
        }

        .input-group-sm>.form-control,.input-group-sm>.input-group-addon,.input-group-sm>.input-group-btn>.btn,.input-sm {
            height: 32px;
            padding: 6px 13px;
            font-size: 12px;
            line-height: 1.5
        }
        .form-control {
            border-radius: 3px;
        }

        .form-control {
            box-shadow: none;
            transition: box-shadow .25s linear,border .25s linear,color .25s linear,background-color .25s linear;
        }

        .form-control {
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .form-control, output {
            display: block;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
        }


        .form-control:not(select) {
            -webkit-appearance: none;
        }
    </style>
    @endsection

@section('content')
    <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> Book New Receipt</h6>
                <div class="heading-elements">

                </div>
            </div>

            {!! Form::open(['route' => 'fieldSavingTransactions.store']) !!}
                 <div class="panel-body">

{{--                     <div class="form-group col-sm-6">--}}
{{--                         <label>Member</label>--}}
{{--                             <select name="member_id" class="form-control select2" required id="member_id">--}}
{{--                                 <option value="">Select member</option>--}}
{{--                                 @if(count($members))--}}
{{--                                     @foreach($members as $member)--}}
{{--                                         <option value="{{ $member->id }}">{{ $member->first_name }}  {{ $member->last_name }}</option>--}}
{{--                                     @endforeach--}}
{{--                                 @endif--}}
{{--                             </select>--}}
{{--                     </div>--}}
                     <div class="form-group col-sm-6">
                         <label>Member</label>
                             <select name="vehicle_id" class="form-control select2" required id="member_id">
                                 <option value="">Select Vehicle</option>
                                 @if(count($memberVehicles))
                                     @foreach($memberVehicles as $memberVehicle)
                                         <option value="{{ $memberVehicle->id }}">{{ $memberVehicle->vehicle->vehicle }} </option>
                                     @endforeach
                                 @endif
                             </select>
                     </div>

                     <div class="form-group col-md-12">
                         <div class="col-md-6">
                             {!! Form::label('payment_method_id',trans_choice('general.payment',1).' '.trans_choice('general.method',1),array('class'=>'col-sm-3 control-label')) !!}
                             {!! Form::select('payment_method_id',$repayment_methods,null, array('class' => ' form-control','required'=>'required','id'=>'payment_method_id')) !!}
                         </div>
                     </div>
                     <div class="form-group col-md-12">
                         <div class="col-sm-6">
                             {!! Form::label('receipt',trans_choice('general.receipt',1),array('class'=>'col-sm-3 control-label')) !!}
                             {!! Form::text('receipt',null, array('class' => 'form-control', 'placeholder'=>"",''=>'required','id'=>'receipt')) !!}
                         </div>
                     </div>
                     <div class="form-group col-md-12">
                         <div class="col-sm-6">
                             <label>Asset Account to</label>
                             <select name="asset_account_to" class="form-control" required>
                                 <option value="">Select Account To</option>
                                 @if(count($accounts))
                                     @foreach($accounts as $account)
                                         <option value="{{ $account->id }}">{{ $account->name }}</option>
                                         @endforeach
                                     @endif
                             </select>
                         </div>
                     </div>
                     <div class="form-group col-md-12">
                         <div class="col-sm-6">
                             {!! Form::label('date',trans_choice('general.date',1),array('class'=>'col-sm-3 control-label')) !!}
                             {!! Form::text('date',date("Y-m-d"), array('class' => 'form-control date-picker', 'placeholder'=>"",'required'=>'required','id'=>'date')) !!}
                         </div>
                     </div>
                     <div class="col-md-12">
                         <label class="control-label">Incomes</label>
                         <hr style="margin-top: 0">
                     </div>
                             @if(count($otherIncomes))
                                    @foreach($otherIncomes as $income)
                                        <div class="form-group col-md-12">
                                            <div class="col-md-3">
                                                <label class="" for="{{$income->id}}">
                                                    {{ $income->name }}
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="otherIncomes[{{$income->id}}]" class="form-control amount">
                                            </div>
                                        </div>

                                    @endforeach
                                 @endif
                     <div class="col-md-12">
                         <label class="control-label">Loan Repayments</label>
                         <hr style="margin-top: 0">
                     </div>
                     <div class="form-group col-md-12">
                         <div class="col-md-3">
                             <label class="" for="">
                                 Loan Repayment
                             </label>
                         </div>
                         <div class="col-md-3">
                             <input type="number" name="loan_repayment" class="form-control amount">
                         </div>
                     </div>
                     <div class="col-md-12">
                         <label class="control-label">Savings</label>
                         <hr style="margin-top: 0">
                     </div>
                             @if(count($saving_products))
                                    @foreach($saving_products as $product)
                                        <div class="form-group col-md-12">
                                            <div class="col-md-3">
                                                <label class="" for="{{$product->id}}">
                                                    {{ $product->name }}
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="savingProducts[{{$product->id}}]" class="form-control amount">
                                            </div>
                                        </div>

                                    @endforeach
                                 @endif
{{--                         </table>--}}

                     <div class="col-md-6">
                         <label class="control-label">Savings</label>
                         <h2 class="inline">Total  <span id="total" class="pull-right"></span> </h2>
                     </div>
                 </div>
                 <div class="panel-footer">
                     <div class="heading-elements">
                         <button type="submit" class="btn btn-primary pull-left" style="margin-left: 10px;">{{trans_choice('general.save',1)}} </button>
                         <a href="{!! route('fieldSavingTransactions.index') !!}" class="btn btn-danger pull-right" >Cancel</a>
                     </div>
                  </div>
            {!! Form::close() !!}
    </div>
@endsection
@section('scripts')
    <script>

        $(document).ready(function(){

            $('body').find($('.amount')).on('keyup',function(){
                // let entered = ;
                if(parseInt($(this).val())){
                    let total = 0;
                    $('.amount').each(function (element,index) {

                        if(parseInt($(this).val())){
                            total = parseInt(total) + parseInt($(this).val());
                        }
                    });
                    // let entered = parseInt($(this).val());
                    // total = parseInt(total) + entered;
                    $('#total').html(total)
                }

            });
        });


        {{--$('#member_id').on('change',function () {--}}
        {{--    let id = $(this).val();--}}
        {{--    let html = '<option value="">Select Member Vehicle</option>';--}}
        {{--    if(id !== ''){--}}
        {{--        $.ajax({--}}
        {{--            url: '{{ url('getVehicles') }}'+'/'+ id,--}}
        {{--            type: 'GET',--}}
        {{--            dataType: 'json',--}}
        {{--            success: function(data){--}}
        {{--                if(data.length){--}}
        {{--                    for (let i =0; i< data.length; i++){--}}
        {{--                        html += '<option value="'+ data[i].vehicle_id+'">'+ data[i].vehicle.vehicle+'</option>'--}}
        {{--                    }--}}
        {{--                }else {--}}
        {{--                    html = '<option value="">No Vehicles Set for this member</option>';--}}
        {{--                }--}}

        {{--                // alert(html);--}}
        {{--               $('#saving-account').html(html)--}}
        {{--            }--}}
        {{--        })--}}
        {{--    }else {--}}
        {{--        $('#saving-account').html(html)--}}
        {{--    }--}}
        {{--})--}}
    </script>
@endsection
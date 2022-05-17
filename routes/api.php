<?php

Route::get('getDelivery',function(\Illuminate\Http\Request $request){
    $message = \App\Models\Sms::find($request->message_id);
    if(!is_null($message)){
        $message->status = $request->status;
        $message->reason = $request->reason;
        $message->save();
    }

    return response()->json(['done'],200);
});

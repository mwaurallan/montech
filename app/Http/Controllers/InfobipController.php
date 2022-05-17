<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use infobip\api\client\GetAccountBalance;
use infobip\api\configuration\BasicAuthConfiguration;

class InfobipController extends Controller
{
    public function getBalance(){
        $client = new GetAccountBalance(new BasicAuthConfiguration('Hentrans','Thika12!@'));
        $response = $client->execute();

        return response()->json(number_format($response->getBalance(),2));
    }

    public function infoBipCallback(Request $request){
        $input = $request->all();
        $result =$input['results'][0];
        $message = CustomerMessage::find($result['callbackData']);
        $message->status = $result['status']['groupName'];
        $message->smsCount = $result['smsCount'];
        $message->message_id = $result['messageId'];
        $message->save();


    }
}

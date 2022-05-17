<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;


class UjumbeSMSGateway extends Controller
{
    //
    private $api_key = "YWEyZjI0MTMzZmM0NDRlNjYxNDRlMzg3NzIyNWRi";
    private $email = "allanmwaura2013@gmail.com";
    private $url = 'https://ujumbesms.co.ke';

    public function getSmsBalance(){
        if($this->canSendSms()){
            $balance = Curl::to($this->url.'/api/balance',['X-Authorization' => $this->api_key,'email' => $this->email])
                ->asJson(true)
                ->withContentType('application/json')
                ->returnResponseObject()
                ->post();
//            return response()->json('here');
        }else{
            $balance = 0;
        }


        return response()->json($balance->content);
    }

    public function canSendSms(){
        return true;
     }

     public function sendSms($data){
        $data = [
            "data" => [[
                "message_bag" => [
                    "numbers" => $data['numbers'],
                    "message" => $data['message'],
                    "sender" => $data['sender'],
                ]
            ]]
        ];

        $sms_data = json_encode($data);

        $sendSms = Curl::to($this->url.'/api/messaging',['X-Authorization' => $this->api_key,'email' => $this->email])
                ->withData([
                    'message' => $sms_data
                ])
                ->asJson(true)
                ->withContentType('application/json')
                ->returnResponseObject()
                ->post();

     }

    public function send($numbers, $message, $sender)
    {

        $data = [
            "numbers" => $numbers,
            "message" => $message,
            "sender" => $sender
        ];
        $this->sendSms($data);

    }

}


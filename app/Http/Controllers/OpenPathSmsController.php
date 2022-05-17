<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

class OpenPathSmsController extends Controller
{
//    private $url = 'http://localhost/bulk/public';
    private $url = 'https://sms.openpathsolutions.co.ke';
    public function getSmsBalance(){
        if($this->canSendSms()){
            $balance = Curl::to($this->url.'/api/getSmsBalance')
                ->withData(['company'=> $this->credentials() ])
                ->asJson(true)
//                ->withContentType('application/json')
                ->returnResponseObject()
                ->post();
//            return response()->json('here');
        }else{
            $balance = 0;
        }


        return response()->json($balance->content);
    }

    public function sendSms($message){
//        if($this->canSendSms()){
            $sendSms = Curl::to($this->url.'/api/sendSms')
                ->withData([
                    'company'=> $this->credentials(),
                    'message' => $message
                ])
                ->asJson(true)
                ->returnResponseObject()
                ->post();
//        }

    }

    public function credentials(){
//        return $cred = Client::find(auth()->user()->client_id);
        $company = [
            'name' => $name = Setting::where('setting_key','company_name')->first()->setting_value,
            'location' => Setting::where('setting_key','company_address')->first()->setting_value,
            'email' => Setting::where('setting_key','company_email')->first()->setting_value,
            'phone_number' => '0715862938',
        ];

        return $company;
    }

    public function canSendSms(){
       return true;
    }

    public function purchaseCreditsStore(Request $request){
        $purchase = Curl::to($this->url.'/api/purchaseCreditsStore')
            ->withData([
                'company'=> $this->credentials(),
                'amount' => $request->amount
            ])
            ->asJson(true)
            ->returnResponseObject()
            ->post();

        return response()->json($purchase->content);
    }
    public function stkSubmit(Request $request){
//        Log::info($request->all());
        $purchase = Curl::to($this->url.'/api/stkSubmit')
            ->withData([
                'invoice'=> $request->invoice,
                'phone' => $request->phone
            ])
            ->asJson(true)
            ->returnResponseObject()
            ->post();

        return response()->json($purchase);
    }
}

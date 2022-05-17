<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\MessageTemplate;
use App\Models\MpesaPayment;
use App\Models\Payment;
use App\Models\PropertyUnit;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Safaricom\Mpesa\Mpesa;

class MpesaController extends Controller
{
    public $access_token;
    private  $configs = array(
        'AccessToken' => '',
        'Environment' => 'live',
        'Content-Type' => 'application/json',
        'Verbose' => 'true',
    );
    public function __construct()
    {

    }

    public function getPayment(Request $request){
            $p_number = '0'.ltrim($request->MSISDN,'254');
            $payment = MpesaPayment::create([
                'payment_mode'=>'MPESA',
                'ref_number'=>$request->TransID,
                'amount'=>$request->TransAmount,
                'paybill'=>$request->BusinessShortCode ?? '',
                'phone_number'=>$p_number,
                'bill_ref_number'=>$request->BillRefNumber ?? '',
                'trans_id'=>$request->TransID,
                'trans_time'=>$request->TransTime,
                'first_name'=>$request->FirstName ?? '',
                'middle_name'=>$request->MiddleName ?? '',
                'last_name'=>$request->LastName ?? '',
                'received_on'=>Carbon::now(),
            ]);

            $template = MessageTemplate::where('event',mpesaPaymentReceived)->where('status',true)->first();
            if(!is_null($template)){
                $message = 'Dear '.$payment->first_name.', we are in receipt of '.number_format($payment->amount).' reference '.$payment->ref_number.' on '
                    .Carbon::now()->format('d/m/Y').'. Thank You.';
                GeneralHelper::send_sms3($payment->phone_number,$message);

            }


        return ['C2BPaymentConfirmationResult'=>'success'];
    }

    public function getPaymentValidation(Request $request){
        return $array = array(
            'ResultCode' => '0',
            'ResultDesc' => 'Service processing successful',
        );
    }

    public function simulate(){
        $mpesa= new Mpesa();
        $c2bTransaction= $mpesa->c2b(862500, 'CustomerPayBillOnline', 1000, 254715862938, '21844232' );
        var_dump($c2bTransaction);
    }

    public function generateToken(){
        return $this->configs['AccessToken'] =  Mpesa::generateLiveToken();
    }

    public function registerUrls(){
        $token = Mpesa::generateLiveToken();

        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
//        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ValidationURL' => 'https://rgsacco.co.ke/getPaymentValidation',
            'ConfirmationURL' => 'https://rgsacco.co.ke/getPayment',
            'ResponseType' => 'Completed',
            'ShortCode' => '5296877',
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        print_r($curl_response);

        echo $curl_response;
    }

}

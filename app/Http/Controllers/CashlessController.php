<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class CashlessController extends Controller
{
    public function makePayment(Request $request){

//        $this->validate($request,[])
        $trip = Trip::find($request->trip_id);

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
}

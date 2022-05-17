<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Interest;
use App\Models\LoanPeriod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Backup\Tasks\Cleanup\Period;

class FrontEndController extends Controller
{
     public function index(){
         return view('front.index');
     }

     public function home(){
         $user = Auth::user();
         return view('front.home',[
             'totalSavings' => Contribution::where('client_id',$user->mf_id)->sum('amount')
         ]);
     }

     public function savings(){
         $member = Auth::user();
         return view('front.my-savings',[
             'savings'=> Contribution::where('client_id',$member->mf_id)->get()
         ]);
     }

     public function loanApplication(){
         $user = Auth::user();
         return view('front.application',[
//             'clients'=>$clients,
             'loan_products'=> Product::all(),
             'rates'=> Interest::all(),
             'periods'=>LoanPeriod::all(),
              'totalSavings' => Contribution::where('client_id',$user->mf_id)->sum('amount')

         ]);
     }
}

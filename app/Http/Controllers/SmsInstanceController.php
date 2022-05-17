<?php

namespace App\Http\Controllers;

use App\Models\SmsInstance;
use Illuminate\Http\Request;

class SmsInstanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('sentinel');
    }

    public function index(){

        return view('communication.index',[
            'instances' => SmsInstance::all()
        ]);
    }
}

<?php

namespace App\Observers;

use App\Models\Sacco;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

//use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class SaccoObserver
{
    public function saving($model)
    {
        //check if the user is logged in
        if($user = Sentinel::check()){
            if(is_null($model->sacco_id)){
                $model->sacco_id = $user->sacco_id;
            }

            //add branch id
            ;
            if(Schema::hasColumn($model->getTable(), 'branch_id') /*&& is_null($model->branch_id)*/){
                $model->branch_id = session('branch_id');
            }
        }

    }
}

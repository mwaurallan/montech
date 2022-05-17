<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingFee extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "savings_fees";


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }



}

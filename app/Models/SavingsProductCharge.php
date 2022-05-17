<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsProductCharge extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "savings_product_charges";

    public function charge()
    {
        return $this->hasOne(Charge::class, 'id', 'charge_id');
    }
}

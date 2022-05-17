<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "charges";

    public function savings_charges()
    {
        return $this->hasMany(SavingsCharge::class, 'charge_id', 'id');
    }
}

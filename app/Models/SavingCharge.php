<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingCharge extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "savings_charges";

}

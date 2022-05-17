<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;


class CollateralType extends Model
{
    use BranchTrait;
    protected $table = "collateral_types";

    public $timestamps = false;
}

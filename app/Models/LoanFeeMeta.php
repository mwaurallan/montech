<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanFeeMeta extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "loan_fees_meta";

    public $timestamps = false;
}

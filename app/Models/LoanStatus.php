<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanStatus extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "loan_status";
    public $timestamps=false;
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanRepaymentMethod extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "loan_repayment_methods";
    public $timestamps=false;
}

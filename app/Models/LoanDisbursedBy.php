<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanDisbursedBy extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "loan_disbursed_by";
    public $timestamps=false;
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanOverduePenalty extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "loan_overdue_penalties";

    public $timestamps = false;


}

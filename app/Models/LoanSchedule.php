<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanSchedule extends Model
{
    use BranchTrait,SoftDeletes;

    protected $table = "loan_schedules";


    public function loan()
    {
        return $this->hasOne(Loan::class, 'id', 'loan_id');
    }

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }
}

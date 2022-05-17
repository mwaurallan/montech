<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanGuarantor extends Model
{
    use BranchTrait;
    protected $table = "loan_guarantors";

    public $timestamps = false;

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function loan()
    {
        return $this->hasOne(Loan::class, 'id', 'loan_id');
    }
    public function guarantor()
    {
        return $this->hasOne(Guarantor::class, 'id', 'guarantor_id');
    }
}

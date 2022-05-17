<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capital extends Model
{
    use SoftDeletes,BranchTrait;
    protected $table = "capital";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function bank()
    {
        return $this->hasOne(BankAccount::class, 'id', 'bank_account_id');
    }
    public function debit_chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'debit_account_id');
    }
    public function credit_chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'credit_account_id');
    }
}

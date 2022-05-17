<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "expenses";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function expense_type()
    {
        return $this->hasOne(ExpenseType::class, 'id', 'expense_type_id');
    }
    public function chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
}

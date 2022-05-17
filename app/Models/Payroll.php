<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "payroll";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'chart_id');
    }
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollTemplate extends Model
{
    use SoftDeletes;
    protected $table = "payroll_templates";
    public $timestamps = false;
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollTemplateMeta extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "payroll_template_meta";
    public $timestamps = false;


}

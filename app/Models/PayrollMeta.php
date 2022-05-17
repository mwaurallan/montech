<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollMeta extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "payroll_meta";
    public $timestamps = false;

    public function payroll_template_meta()
    {
        return $this->hasOne(PayrollTemplateMeta::class, 'id', 'payroll_template_meta_id');
    }
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvisionRate extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "provision_rates";

    public $timestamps = false;

}

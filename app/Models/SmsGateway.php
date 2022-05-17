<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsGateway extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "sms_gateways";

    public $timestamps = false;
}

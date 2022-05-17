<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use BranchTrait;
    protected $table = "custom_fields";
    public $timestamps=false;
}

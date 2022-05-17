<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "settings";
    public  $timestamps=false;

    protected $guarded = [];
}

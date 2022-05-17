<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "suppliers";

    public $timestamps = false;


}

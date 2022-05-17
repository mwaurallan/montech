<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWarehouse extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "product_warehouses";

    public $timestamps = false;


}

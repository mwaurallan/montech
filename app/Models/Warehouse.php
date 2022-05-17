<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "warehouses";

    public $timestamps = false;

    public function assets()
    {
        return $this->hasMany(Asset::class, 'asset_type_id', 'id');
    }
}

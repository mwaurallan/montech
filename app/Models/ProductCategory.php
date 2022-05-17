<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "product_categories";

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(ProductCategoryMeta::class, 'product_category_id', 'id');
    }
}

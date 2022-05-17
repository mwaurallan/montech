<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCheckoutItem extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "product_check_out_items";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function items()
    {
        return $this->hasMany(ProductCheckinItem::class, 'product_check_in_id', 'id');
    }

    public function checkout(){
        return $this->belongsTo(ProductCheckout::class,'product_check_out_id');
    }
}

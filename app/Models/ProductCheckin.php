<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCheckin extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "product_check_ins";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(ProductCheckinItem::class, 'product_check_in_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(ProductPayment::class, 'product_check_in_id', 'id')->orderBy('date','desc');
    }
}

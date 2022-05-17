<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCheckout extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "product_check_outs";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }

    public function items()
    {
        return $this->hasMany(ProductCheckoutItem::class, 'product_check_out_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(ProductPayment::class, 'product_check_in_id', 'id')->orderBy('date', 'desc');
    }
}

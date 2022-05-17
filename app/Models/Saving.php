<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saving extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "savings";
    protected $guarded = [];


    public function saving_transactions()
    {
        return $this->hasMany(SavingTransaction::class, 'savings_id', 'id');
    }

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id')->withTrashed();
    }

    public function savings_product()
    {
        return $this->hasOne(SavingProduct::class, 'id', 'savings_product_id');
    }
    public function product()
    {
        return $this->hasOne(SavingProduct::class, 'id', 'savings_product_id');
    }


}

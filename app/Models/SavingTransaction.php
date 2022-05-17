<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingTransaction extends Model
{

    use BranchTrait,SoftDeletes;
    protected $table = "savings_transactions";

//    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];



    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'id', 'borrower_id');
    }
    public function payment_method()
    {
        return $this->hasOne(LoanRepaymentMethod::class, 'id', 'payment_method_id');
    }
    public function savings()
    {
        return $this->hasOne(Saving::class, 'id', 'savings_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id')->withDefault([
            'vehicle'=> ' - '
        ]);
    }


}

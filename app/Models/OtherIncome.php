<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherIncome extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "other_income";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withDefault([
            'full_name' => '-'
        ]);
    }

    public function other_income_type()
    {
        return $this->hasOne(OtherIncomeType::class, 'id', 'other_income_type_id');
    }
    public function type()
    {
        return $this->hasOne(OtherIncomeType::class, 'id', 'other_income_type_id');
    }

    public function chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }


    public function borrower(){
        return $this->belongsTo(Borrower::class, 'borrower_id')->withDefault([
            'first_name' => '-',
            'last_name' => '-',
        ]);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id')->withDefault([
            'vehicle' => '-'
        ]);
    }
}

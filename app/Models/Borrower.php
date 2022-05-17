<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    use SoftDeletes,BranchTrait;
    protected $table = "borrowers";
    protected $guarded = [];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function loans()
    {
        return $this->hasMany(Loan::class, 'borrower_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(LoanRepayment::class, 'borrower_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
}

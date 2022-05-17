<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $table = "audit_trail";
    use BranchTrait;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}

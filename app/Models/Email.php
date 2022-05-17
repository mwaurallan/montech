<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use BranchTrait;
    protected $table = "emails";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

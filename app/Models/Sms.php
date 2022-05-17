<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "sms";

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCountAttribute(){
        switch ($length = strlen($this->message)){
            case $length <= 140: return 1;
            case $length >140 && $length <= 280: return 2;
            case $length >280 && $length <= 420: return 3;
            default: return 4;
        }
    }
}

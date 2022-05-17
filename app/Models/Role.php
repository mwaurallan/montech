<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = 'roles';

    protected $guarded = [];
    protected static $usersModel = 'Cartalyst\Sentinel\Users\EloquentUser';

    public function users()
    {
        return $this->belongsToMany(static::$usersModel, 'role_users', 'role_id', 'user_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
//    use BranchTrait;
    protected $table = "branches";

    protected $fillable = [
        'name',
        'assigned_users',
        'notes',
        'sacco_id',
        'default_branch'
    ];

    public $timestamps = false;
    public function users()
    {
        return $this->hasMany(BranchUser::class, 'branch_id', 'id');
    }
}

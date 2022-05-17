<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowerGroup extends Model
{
    use BranchTrait,SoftDeletes;
    protected $table = "borrower_groups";

    public function members()
    {
        return $this->hasMany(BorrowerGroupMember::class, 'borrower_group_id', 'id');
    }
}

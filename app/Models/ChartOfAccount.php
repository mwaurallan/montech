<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use BranchTrait;
    protected $table = "chart_of_accounts";

    public $timestamps = false;

    protected $guarded = [];


}

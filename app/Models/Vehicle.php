<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle
 * @package App\Models
 * @version September 23, 2019, 5:05 pm UTC
 *
 * @property string vehicle
 * @property boolean status
 * @property integer sacco_id
 */
class Vehicle extends Model
{
    use SoftDeletes,BranchTrait;

    public $table = 'vehicles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'vehicle',
        'status',
        'sacco_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'vehicle' => 'string',
        'status' => 'boolean',
        'sacco_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'vehicle' => 'required|size:7',
//        'status' => 'required'
    ];


}

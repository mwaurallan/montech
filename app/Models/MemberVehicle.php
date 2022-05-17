<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

/**
 * Class MemberVehicle
 * @package App\Models
 * @version September 23, 2019, 5:58 pm UTC
 *
 * @property \App\Models\Borrower member
 * @property \App\Models\Vehicle vehicle
 * @property integer member_id
 * @property integer vehicle_id
 * @property boolean status
 */
class MemberVehicle extends Model
{
    use SoftDeletes;

    public $table = 'member_vehicles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'member_id',
        'vehicle_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'member_id' => 'integer',
        'vehicle_id' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'member_id' => 'required',
////        'vehicle_id' => 'required|unique:member_vehicles,vehicle_id',
//        'vehicle_id' => Rule::unique('member_vehicles')->where(function(){})
////        'status' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function member()
    {
        return $this->belongsTo(\App\Models\Borrower::class, 'member_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Vehicle::class, 'vehicle_id')->withTrashed();
    }
}

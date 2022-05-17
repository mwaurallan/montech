<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Trip
 * @package App\Models
 * @version July 27, 2020, 10:32 am EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection $tripPassengers
 * @property \Illuminate\Database\Eloquent\Collection $tripPayments
 * @property integer $member_vehicle_id
 * @property string $from
 * @property string $to
 * @property string $driver
 * @property string $conductor
 */
class Trip extends Model
{
    use SoftDeletes;

    public $table = 'trips';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'member_vehicle_id',
        'from',
        'to',
        'driver',
        'status',
        'conductor'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'member_vehicle_id' => 'integer',
        'from' => 'string',
        'to' => 'string',
        'driver' => 'string',
        'conductor' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'member_vehicle_id' => 'required',
        'from' => 'required',
        'to' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tripPassengers()
    {
        return $this->hasMany(\App\Models\TripPassenger::class, 'trip_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tripPayments()
    {
        return $this->hasMany(\App\Models\TripPayment::class, 'trip_id');
    }

    public function vehicle(){
        return $this->belongsTo(MemberVehicle::class,'member_vehicle_id');
    }
}

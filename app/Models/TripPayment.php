<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TripPayment
 * @package App\Models
 * @version July 27, 2020, 11:46 am EAT
 *
 * @property \App\Models\Passenger $passenger
 * @property \App\Models\Payment $payment
 * @property \App\Models\Trip $trip
 * @property integer $trip_id
 * @property integer $payment_id
 * @property integer $passenger_id
 * @property string|\Carbon\Carbon $date
 */
class TripPayment extends Model
{
    use SoftDeletes;

    public $table = 'trip_payments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'trip_id',
        'payment_id',
        'passenger_id',
        'date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'trip_id' => 'integer',
        'payment_id' => 'integer',
        'passenger_id' => 'integer',
        'date' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'trip_id' => 'required',
        'payment_id' => 'required',
        'passenger_id' => 'required',
        'date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function passenger()
    {
        return $this->belongsTo(\App\Models\Passenger::class, 'passenger_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function trip()
    {
        return $this->belongsTo(\App\Models\Trip::class, 'trip_id');
    }
}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Passenger
 * @package App\Models
 * @version July 28, 2020, 6:59 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection $tripPassengers
 * @property \Illuminate\Database\Eloquent\Collection $tripPayments
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $id_number
 */
class Passenger extends Model
{
    use SoftDeletes;

    public $table = 'passengers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'id_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'middle_name' => 'string',
        'last_name' => 'string',
        'phone_number' => 'string',
        'id_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tripPassengers()
    {
        return $this->hasMany(\App\Models\TripPassenger::class, 'passenger_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tripPayments()
    {
        return $this->hasMany(\App\Models\TripPayment::class, 'passenger_id');
    }
}

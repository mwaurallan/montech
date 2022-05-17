<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Payment
 * @package App\Models
 * @version July 28, 2020, 7:30 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection $tripPayments
 * @property string $payment_mode
 * @property string $source
 * @property string $ref_number
 * @property number $amount
 * @property string $paybill
 * @property string $phone_number
 * @property string $bill_ref_number
 * @property string $trans_id
 * @property string|\Carbon\Carbon $trans_time
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string|\Carbon\Carbon $received_on
 * @property boolean $status
 */
class Payment extends Model
{
    use SoftDeletes;

    public $table = 'payments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'payment_mode',
        'source',
        'ref_number',
        'amount',
        'paybill',
        'phone_number',
        'bill_ref_number',
        'trans_id',
        'trans_time',
        'first_name',
        'middle_name',
        'last_name',
        'received_on',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_mode' => 'string',
        'source' => 'string',
        'ref_number' => 'string',
        'amount' => 'float',
        'paybill' => 'string',
        'phone_number' => 'string',
        'bill_ref_number' => 'string',
        'trans_id' => 'string',
        'trans_time' => 'datetime',
        'first_name' => 'string',
        'middle_name' => 'string',
        'last_name' => 'string',
        'received_on' => 'datetime',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'payment_mode' => 'required',
        'amount' => 'required',
        'status' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tripPayments()
    {
        return $this->hasMany(\App\Models\TripPayment::class, 'payment_id');
    }
}

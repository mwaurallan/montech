<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class InvoicePayment
 * @package App\Models
 * @version August 13, 2020, 2:37 pm EAT
 *
 * @property string $ref_number
 * @property string|\Carbon\Carbon $date_paid
 * @property number $amount
 * @property integer $sacco_id
 */
class InvoicePayment extends Model
{
    use SoftDeletes;

    public $table = 'invoice_payments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'ref_number',
        'date_paid',
        'amount',
        'sacco_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ref_number' => 'string',
        'date_paid' => 'datetime',
        'amount' => 'float',
        'sacco_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_paid' => 'required',
        'amount' => 'required',
//        'sacco_id' => 'required'
    ];


}

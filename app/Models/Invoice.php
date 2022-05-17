<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoice
 * @package App\Models
 * @version August 13, 2020, 2:36 pm EAT
 *
 * @property integer $sacco_id
 * @property string $invoice_date
 * @property string $due_date
 * @property number $amount
 * @property boolean $status
 */
class Invoice extends Model
{
    use SoftDeletes;

    public $table = 'invoices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'sacco_id',
        'invoice_date',
        'due_date',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sacco_id' => 'integer',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'amount' => 'float',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'sacco_id' => 'required',
        'invoice_date' => 'required',
        'due_date' => 'required',
        'amount' => 'required',
//        'status' => 'required'
    ];


}

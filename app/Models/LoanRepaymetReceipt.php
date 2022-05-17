<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LoanRepaymetReceipt
 * @package App\Models
 * @version October 9, 2019, 1:47 pm EAT
 *
 * @property integer borrower_id
 * @property string date
 * @property integer vehicle_id
 * @property string receipt
 * @property number amount
 * @property integer user_id
 * @property boolean status
 */
class LoanRepaymetReceipt extends Model
{
    use SoftDeletes;

    public $table = 'loan_payment_receipts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'borrower_id' => 'integer',
        'date' => 'date',
        'vehicle_id' => 'integer',
        'receipt' => 'string',
        'amount' => 'float',
        'user_id' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'borrower_id' => 'required',
        'date' => 'required',
        'amount' => 'required',
        'status' => 'required'
    ];

    public function member(){
        return $this->belongsTo(Borrower::class,'borrower_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    
}

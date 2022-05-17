<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FieldSavingTransaction
 * @package App\Models
 * @version September 25, 2019, 5:30 pm UTC
 *
 * @property \App\Models\Sacco sacco
 * @property integer user_id
 * @property integer borrower_id
 * @property integer savings_id
 * @property number amount
 * @property integer vehicle_id
 * @property string type
 * @property boolean system_interest
 * @property string date
 * @property string time
 * @property string year
 * @property string month
 * @property string notes
 * @property integer sacco_id
 */
class FieldSavingTransaction extends Model
{
    use SoftDeletes;

    public $table = 'field_saving_transactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'borrower_id',
        'savings_id',
        'amount',
        'vehicle_id',
        'type',
        'system_interest',
        'date',
        'time',
        'year',
        'month',
        'notes',
        'sacco_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'borrower_id' => 'integer',
        'savings_id' => 'integer',
        'amount' => 'float',
        'vehicle_id' => 'integer',
        'type' => 'string',
        'system_interest' => 'boolean',
        'date' => 'date',
        'time' => 'string',
        'year' => 'string',
        'month' => 'string',
        'notes' => 'string',
        'sacco_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'system_interest' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sacco()
    {
        return $this->belongsTo(\App\Models\Sacco::class, 'sacco_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id')->withTrashed()->withDefault('');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account(){
        return $this->belongsTo(SavingProduct::class,'savings_id')->withTrashed();
    }
}

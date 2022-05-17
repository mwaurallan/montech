<?php

namespace App\Repositories;

use App\Models\FieldSavingTransaction;
use App\Repositories\BaseRepository;

/**
 * Class FieldSavingTransactionRepository
 * @package App\Repositories
 * @version September 25, 2019, 5:30 pm UTC
*/

class FieldSavingTransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FieldSavingTransaction::class;
    }
}

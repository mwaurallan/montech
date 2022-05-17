<?php

namespace App\Repositories;

use App\Models\SavingTransaction;
use App\Repositories\BaseRepository;

/**
 * Class SavingTransactionRepository
 * @package App\Repositories
 * @version July 29, 2020, 7:15 pm EAT
*/

class SavingTransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'borrower_id',
        'savings_id',
        'amount',
        'type',
        'system_interest',
        'date',
        'time',
        'year',
        'month',
        'notes',
        'sacco_id',
        'branch_id',
        'receipt',
        'payment_method_id',
        'debit',
        'credit',
        'balance',
        'reversible',
        'reversed',
        'reversal_type',
        'reference',
        'vehicle_id'
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
        return SavingTransaction::class;
    }
}

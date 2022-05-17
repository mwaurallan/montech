<?php

namespace App\Repositories;

use App\Models\Income;
use App\Repositories\BaseRepository;

/**
 * Class IncomeRepository
 * @package App\Repositories
 * @version July 29, 2020, 8:49 pm EAT
*/

class IncomeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'other_income_type_id',
        'amount',
        'date',
        'year',
        'month',
        'notes',
        'files',
        'sacco_id',
        'branch_id',
        'chart_id',
        'account_id',
        'borrower_id',
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
        return Income::class;
    }
}

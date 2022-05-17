<?php

namespace App\Repositories;

use App\Models\LoanRepaymetReceipt;
use App\Repositories\BaseRepository;

/**
 * Class LoanRepaymetReceiptRepository
 * @package App\Repositories
 * @version October 9, 2019, 1:47 pm EAT
*/

class LoanRepaymetReceiptRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'borrower_id',
        'date',
        'vehicle_id',
        'receipt',
        'amount',
        'user_id',
        'status'
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
        return LoanRepaymetReceipt::class;
    }
}

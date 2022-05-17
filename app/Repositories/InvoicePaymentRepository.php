<?php

namespace App\Repositories;

use App\Models\InvoicePayment;
use App\Repositories\BaseRepository;

/**
 * Class InvoicePaymentRepository
 * @package App\Repositories
 * @version August 13, 2020, 2:37 pm EAT
*/

class InvoicePaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ref_number',
        'date_paid',
        'amount',
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
        return InvoicePayment::class;
    }
}

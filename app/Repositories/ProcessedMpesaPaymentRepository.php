<?php

namespace App\Repositories;

use App\Models\ProcessedMpesaPayment;
use App\Repositories\BaseRepository;

/**
 * Class ProcessedMpesaPaymentRepository
 * @package App\Repositories
 * @version August 18, 2020, 11:16 am EAT
*/

class ProcessedMpesaPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payment_mode',
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
        'status',
        'borrower_id'
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
        return ProcessedMpesaPayment::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\MpesaPayment;
use App\Repositories\BaseRepository;

/**
 * Class MpesaPaymentRepository
 * @package App\Repositories
 * @version August 13, 2020, 8:15 pm EAT
*/

class MpesaPaymentRepository extends BaseRepository
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
        return MpesaPayment::class;
    }
}

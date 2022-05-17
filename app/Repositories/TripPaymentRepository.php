<?php

namespace App\Repositories;

use App\Models\TripPayment;
use App\Repositories\BaseRepository;

/**
 * Class TripPaymentRepository
 * @package App\Repositories
 * @version July 27, 2020, 11:46 am EAT
*/

class TripPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'trip_id',
        'payment_id',
        'passenger_id',
        'date'
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
        return TripPayment::class;
    }
}

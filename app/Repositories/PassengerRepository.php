<?php

namespace App\Repositories;

use App\Models\Passenger;
use App\Repositories\BaseRepository;

/**
 * Class PassengerRepository
 * @package App\Repositories
 * @version July 28, 2020, 6:59 pm EAT
*/

class PassengerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'id_number'
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
        return Passenger::class;
    }
}

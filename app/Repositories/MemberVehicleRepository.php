<?php

namespace App\Repositories;

use App\Models\MemberVehicle;
use App\Repositories\BaseRepository;

/**
 * Class MemberVehicleRepository
 * @package App\Repositories
 * @version September 23, 2019, 5:58 pm UTC
*/

class MemberVehicleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'member_id',
        'vehicle_id',
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
        return MemberVehicle::class;
    }
}

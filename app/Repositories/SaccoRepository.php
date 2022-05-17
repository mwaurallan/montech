<?php

namespace App\Repositories;

use App\Models\Sacco;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SaccoRepository
 * @package App\Repositories
 * @version July 17, 2019, 1:17 pm UTC
 *
 * @method Sacco findWithoutFail($id, $columns = ['*'])
 * @method Sacco find($id, $columns = ['*'])
 * @method Sacco first($columns = ['*'])
*/
class SaccoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'location'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sacco::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Sms;
use App\Repositories\BaseRepository;

/**
 * Class SmsRepository
 * @package App\Repositories
 * @version July 29, 2020, 6:11 pm EAT
*/

class SmsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'message',
        'recipients',
        'send_to',
        'notes',
        'gateway',
        'sacco_id',
        'branch_id',
        'name',
        'status',
        'reason',
        'sender',
        'delivery_checked',
        'sent'
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
        return Sms::class;
    }
}

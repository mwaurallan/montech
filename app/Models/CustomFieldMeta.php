<?php

namespace App\Models;

use App\Traits\BranchTrait;
use Illuminate\Database\Eloquent\Model;

class CustomFieldMeta extends Model
{
    use BranchTrait;
    protected $table = "custom_fields_meta";
    public $timestamps = false;

    public function custom_field()
    {
        return $this->hasOne(CustomField::class, 'id', 'custom_field_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantType extends Model
{
    protected $table = 'CONSULTANT_TYPE';

    protected $primaryKey = 'CONSULTANT_TYPE_ID';

    public $timestamps = false;

    public function setSelected($value)
    {
        $this->attributes['selected'] = $value;
    }
}
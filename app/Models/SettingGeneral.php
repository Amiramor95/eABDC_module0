<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGeneral extends Model
{
    protected $table = 'SETTING_GENERAL';

    protected $primaryKey = 'SETTING_GENERAL_ID';

    public $timestamps = false;

    public function setSelected($value)
    {
        $this->attributes['selected'] = $value;
    }
}
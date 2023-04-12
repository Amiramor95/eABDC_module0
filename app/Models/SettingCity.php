<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingCity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_CITY';

    protected $primaryKey = 'SETTING_CITY_ID';

    public $timestamps = false;
}
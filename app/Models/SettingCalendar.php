<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingCalendar extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_CALENDAR';

    protected $primaryKey = 'SETTING_CALENDAR_ID';

    public $timestamps = false;
}
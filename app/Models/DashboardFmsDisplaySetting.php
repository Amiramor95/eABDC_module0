<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class DashboardFmsDisplaySetting extends Model
{
    protected $table = 'DASHBOARD_FMS_DISPLAY_SETTING';

    protected $primaryKey = 'DISPLAY_SETTING_ID';

    public $timestamps = false;
}
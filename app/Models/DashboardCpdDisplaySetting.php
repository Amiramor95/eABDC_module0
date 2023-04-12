<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class DashboardCpdDisplaySetting extends Model
{
    protected $table = 'DASHBOARD_CPD_DISPLAY_SETTING';

    protected $primaryKey = 'DISPLAY_SETTING_ID';

    public $timestamps = false;
}
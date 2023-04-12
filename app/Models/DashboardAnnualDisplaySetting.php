<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class DashboardAnnualDisplaySetting extends Model
{
    protected $table = 'DASHBOARD_ANNUAL_DISPLAY_SETTING';

    protected $primaryKey = 'DISPLAY_SETTING_ID';

    public $timestamps = false;
}
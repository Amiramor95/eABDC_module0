<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class DashboardConsultantDisplaySetting extends Model
{
    protected $table = 'DASHBOARD_CONSULTANT_DISPLAY_SETTING';

    protected $primaryKey = 'DISPLAY_SETTING_ID';

    public $timestamps = false;
}
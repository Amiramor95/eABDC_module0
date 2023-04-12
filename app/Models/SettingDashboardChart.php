<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingDashboardChart extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_DASHBOARD_CHART';

    protected $primaryKey = 'SETTING_DASHBOARD_CHART_ID';

    public $timestamps = false;
}
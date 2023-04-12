<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorSetting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_SETTING';

    protected $primaryKey = 'DISTRIBUTOR_SETTING_ID';

    public $timestamps = false;
}
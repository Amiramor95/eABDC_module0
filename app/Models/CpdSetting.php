<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpdSetting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CPD_SETTING';

    protected $primaryKey = 'CPD_SETTING_ID';

    public $timestamps = false;
}
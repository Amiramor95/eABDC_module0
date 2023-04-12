<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingPostal extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_POSTAL';

    protected $primaryKey = 'SETTING_POSTCODE_ID';

    public $timestamps = false;
}
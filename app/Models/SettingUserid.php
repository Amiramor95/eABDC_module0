<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingUserid extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_USERID';

    protected $primaryKey = 'SETTING_USERID_ID';

    public $timestamps = false;
}
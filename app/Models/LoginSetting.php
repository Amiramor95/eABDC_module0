<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LoginSetting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'LOGIN_SETTING';

    protected $primaryKey = 'LOGIN_SETTING_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class SettingHttp extends Model
{
    //use \OwenIt\Auditing\Auditable;
    protected $table = 'SETTING_HTTP';

    protected $primaryKey = 'SETTING_HTTP_ID';

    public $timestamps = false;
}
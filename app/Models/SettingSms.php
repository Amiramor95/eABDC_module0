<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingSms extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SETTING_SMS';

    protected $primaryKey = 'SETTING_SMS_ID';

    public $timestamps = false;
}
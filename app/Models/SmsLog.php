<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SmsLog extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SMS_LOG';

    protected $primaryKey = 'SMS_LOG_ID';

    public $timestamps = false;
}
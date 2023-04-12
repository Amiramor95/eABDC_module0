<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantNotification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_NOTIFICATION';

    protected $primaryKey = 'CONSULTANT_NOTIFICATION_ID';

    public $timestamps = false;
}
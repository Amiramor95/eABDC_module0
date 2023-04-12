<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'NOTIFICATION';

    protected $primaryKey = 'NOTIFICATION_ID';

    public $timestamps = false;
}
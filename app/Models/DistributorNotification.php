<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorNotification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_NOTIFICATION';

    protected $primaryKey = 'DISTRIBUTOR_NOTIFICATION_ID';

    public $timestamps = false;
}
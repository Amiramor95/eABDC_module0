<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PurgeDataPeriod extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'PURGE_DATA_PERIOD';

    protected $primaryKey = 'PURGE_DATA_ID';

    public $timestamps = false;
}
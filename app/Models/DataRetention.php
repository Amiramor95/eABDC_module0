<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DataRetention extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DATA_RETENTION';

    protected $primaryKey = 'DATA_RETENTION_ID';

    public $timestamps = false;
}
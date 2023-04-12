<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SystemBlockDuration extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SYSTEM_BLOCK_DURATION';

    protected $primaryKey = 'SYSTEM_BLOCK_DURATION_ID';

    public $timestamps = false;
}
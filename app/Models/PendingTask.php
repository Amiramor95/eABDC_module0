<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PendingTask extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'PENDING_TASK';

    protected $primaryKey = 'PENDING_TASK_ID';

    public $timestamps = false;
}
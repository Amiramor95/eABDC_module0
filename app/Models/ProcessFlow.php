<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProcessFlow extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'PROCESS_FLOW';
    protected $primaryKey = 'PROCESS_FLOW_ID';

    public $timestamps = false;
}
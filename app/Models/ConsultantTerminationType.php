<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantTerminationType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_TERMINATION_TYPE';

    protected $primaryKey = 'CONSULTANT_TERMINATION_TYPE_ID';

    public $timestamps = false;
}
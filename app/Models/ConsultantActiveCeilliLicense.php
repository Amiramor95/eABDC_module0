<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantActiveCeilliLicense extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_ACTIVE_CEILLI_LICENSE';

    protected $primaryKey = 'CONSULTANT_ACTIVE_CEILLI_LICENSE_ID';

    public $timestamps = false;
}
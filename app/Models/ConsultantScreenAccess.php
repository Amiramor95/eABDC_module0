<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantScreenAccess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_SCREEN_ACCESS';

    protected $primaryKey = 'CONSULTANT_SCREEN_ACCESS_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantManageModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_MANAGE_MODULE';

    protected $primaryKey = 'CONSULTANT_MANAGE_MODULE_ID';

    public $timestamps = false;
}
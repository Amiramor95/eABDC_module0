<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantManageSubmodule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_MANAGE_SUBMODULE';

    protected $primaryKey = 'CONSULTANT_MANAGE_SUBMODULE_ID';

    public $timestamps = false;
}
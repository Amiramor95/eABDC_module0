<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TpManageSubmodule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TP_MANAGE_SUBMODULE';

    protected $primaryKey = 'TP_MANAGE_SUBMODULE_ID';

    public $timestamps = false;
}
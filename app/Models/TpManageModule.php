<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TpManageModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TP_MANAGE_MODULE';

    protected $primaryKey = 'TP_MANAGE_MODULE_ID';

    public $timestamps = false;
}
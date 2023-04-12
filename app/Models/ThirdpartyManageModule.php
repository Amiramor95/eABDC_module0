<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ThirdpartyManageModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'THIRDPARTY_MANAGE_MODULE';

    protected $primaryKey = 'THIRDPARTY_MANAGE_MODULE_ID';

    public $timestamps = false;
}
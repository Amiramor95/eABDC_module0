<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ThirdpartyManageSubmodule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'THIRDPARTY_SUBMODULE';

    protected $primaryKey = 'THIRDPARTY_SUBMODULE_ID';

    public $timestamps = false;
}
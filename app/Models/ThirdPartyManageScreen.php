<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ThirdPartyManageScreen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'THIRDPARTY_MANAGE_SCREEN';

    protected $primaryKey = 'THIRDPARTY_MANAGE_SCREEN_ID';

    public $timestamps = false;
}
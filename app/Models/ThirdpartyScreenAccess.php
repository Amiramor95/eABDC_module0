<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ThirdpartyScreenAccess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'THIRDPARTY_SCREEN_ACCESS';

    protected $primaryKey = 'THIRDPARTY_SCREEN_ACCESS_ID';

    public $timestamps = false;
}
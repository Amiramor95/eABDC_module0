<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TpScreenAccess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TP_SCREEN_ACCESS';

    protected $primaryKey = 'TP_SCREEN_ACCESS_ID';

    public $timestamps = false;
}
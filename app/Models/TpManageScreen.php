<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TpManageScreen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TP_MANAGE_SCREEN';

    protected $primaryKey = 'TP_MANAGE_SCREEN_ID';

    public $timestamps = false;
}
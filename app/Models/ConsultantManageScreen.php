<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantManageScreen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_MANAGE_SCREEN';

    protected $primaryKey = 'CONSULTANT_MANAGE_SCREEN_ID';

    public $timestamps = false;
}
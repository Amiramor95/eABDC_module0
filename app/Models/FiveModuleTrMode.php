<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FiveModuleTrMode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FIVE_MODULE_TR_MODE';

    protected $primaryKey = 'FIVE_MODULE_TR_MODE_ID';

    public $timestamps = false;
}
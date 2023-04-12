<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpdModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CPD_MODULE';

    protected $primaryKey = 'CPD_MODULE_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ModuleCode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'MODULE_CODE';

    protected $primaryKey = 'MODULE_CODE_ID';

    public $timestamps = false;
}
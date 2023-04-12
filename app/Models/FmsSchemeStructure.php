<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsSchemeStructure extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_SCHEME_STRUCTURE';

    protected $primaryKey = 'FMS_SCHEME_ID';

    public $timestamps = false;
}
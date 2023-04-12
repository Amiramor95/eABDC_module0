<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LsMethod extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'LS_METHOD';

    protected $primaryKey = 'LS_METHOD_ID';

    public $timestamps = false;
}
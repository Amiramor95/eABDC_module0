<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FpCode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FP_CODE';

    protected $primaryKey = 'FP_CODE_ID';

    public $timestamps = false;
}
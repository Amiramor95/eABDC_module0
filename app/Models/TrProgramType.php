<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrProgramType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TR_PROGRAM_TYPE';

    protected $primaryKey = 'TR_PROGRAM_TYPE_ID';

    public $timestamps = false;
}
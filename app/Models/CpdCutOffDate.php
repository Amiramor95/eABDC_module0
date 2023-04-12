<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpdCutOffDate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CPD_CUT_OFF_DATE';

    protected $primaryKey = 'CPD_CUT_OFF_DATE_ID';

    public $timestamps = false;
}
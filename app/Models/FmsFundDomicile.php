<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsFundDomicile extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_FUND_DOMICILE';

    protected $primaryKey = 'FUND_DOMICILE_ID';

    public $timestamps = false;
}
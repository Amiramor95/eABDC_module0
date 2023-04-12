<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnnualFeesDate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'ANNUAL_FEES_DATE';

    protected $primaryKey = 'ANNUAL_FEES_DATE_ID';

    public $timestamps = false;
}
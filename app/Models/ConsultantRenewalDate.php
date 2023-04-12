<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantRenewalDate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_RENEWAL_DATE';

    protected $primaryKey = 'CONSULTANT_RENEWAL_DATE_ID';

    public $timestamps = false;
}
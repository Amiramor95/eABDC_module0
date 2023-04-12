<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RnaVerificationPeriod extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'RNA_VERIFICATION_PERIOD';

    protected $primaryKey = 'RNA_VERIFICATION_PERIOD_ID';

    public $timestamps = false;
}
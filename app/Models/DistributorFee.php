<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorFee extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_FEE';

    protected $primaryKey = 'DISTRIBUTOR_FEE_ID';

    public $timestamps = false;
}
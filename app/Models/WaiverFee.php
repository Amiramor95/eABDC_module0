<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WaiverFee extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'WAIVER_FEE';

    protected $primaryKey = 'WAIVER_FEE_ID';

    public $timestamps = false;
}
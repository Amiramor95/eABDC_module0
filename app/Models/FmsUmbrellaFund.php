<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsUmbrellaFund extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_UMBRELLA_FUND';

    protected $primaryKey = 'FMS_UMBRELLA_FUND_ID';

    public $timestamps = false;
}
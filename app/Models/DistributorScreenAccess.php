<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorScreenAccess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_SCREEN_ACCESS';

    protected $primaryKey = 'DISTRIBUTOR_SCREEN_ACCESS_ID';

    public $timestamps = false;
}
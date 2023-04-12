<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorManageModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_MANAGE_MODULE';

    protected $primaryKey = 'DISTRIBUTOR_MANAGE_MODULE_ID';

    public $timestamps = false;
}
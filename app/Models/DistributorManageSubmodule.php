<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorManageSubmodule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_MANAGE_SUBMODULE';

    protected $primaryKey = 'DISTRIBUTOR_MANAGE_SUBMODULE_ID';

    public $timestamps = false;
}
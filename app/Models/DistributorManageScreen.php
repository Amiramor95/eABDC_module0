<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorManageScreen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_MANAGE_SCREEN';

    protected $primaryKey = 'DISTRIBUTOR_MANAGE_SCREEN_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistApprovalLevel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_APPROVAL_LEVEL';

    protected $primaryKey = 'DISTRIBUTOR_APPROVAL_LEVEL_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorManageGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_MANAGE_GROUP';

    protected $primaryKey = 'DISTRIBUTOR_MANAGE_GROUP_ID';

    public $timestamps = false;
}
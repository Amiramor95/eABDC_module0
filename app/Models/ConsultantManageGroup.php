<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantManageGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_MANAGE_GROUP';

    protected $primaryKey = 'CONSULTANT_MANAGE_GROUP_ID';

    public $timestamps = false;
}
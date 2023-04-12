<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TpManageGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TP_MANAGE_GROUP';

    protected $primaryKey = 'TP_MANAGE_GROUP_ID';

    public $timestamps = false;
}
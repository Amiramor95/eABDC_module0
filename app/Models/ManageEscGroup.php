<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageEscGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'MANAGE_ESC_GROUP';

    protected $primaryKey = 'MANAGE_ESC_GROUP_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageScreenAccess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'MANAGE_SCREEN_ACCESS';

    protected $primaryKey = 'MANAGE_SCREEN_ACCESS_ID';

    public $timestamps = false;
}
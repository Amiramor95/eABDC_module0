<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ApprovalLevel extends Model 
{
    //use \OwenIt\Auditing\Auditable;
    
    protected $table = 'APPROVAL_LEVEL';

    protected $primaryKey = 'APPROVAL_LEVEL_ID';

    public $timestamps = false;
}
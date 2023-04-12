<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CircularEventApproval extends Model 
{
    // use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CIRCULAR_EVENT_APPROVAL';

    protected $primaryKey = 'CIRCULAR_EVENT_APPROVAL_ID';

    public $timestamps = false;
}
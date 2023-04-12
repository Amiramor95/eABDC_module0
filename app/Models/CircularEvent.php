<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CircularEvent extends Model 
{
    // use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CIRCULAR_EVENT';

    protected $primaryKey = 'CIRCULAR_EVENT_ID';

    public $timestamps = false;
}
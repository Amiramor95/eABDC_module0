<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CircularEventDocument extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CIRCULAR_EVENT_DOCUMENT';

    protected $primaryKey = 'CIRCULAR_EVENT_DOCUMENT_ID';

    public $timestamps = false;
}


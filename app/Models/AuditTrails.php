<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;

class AuditTrails extends Model implements Auditable
{
    // use \OwenIt\Auditing\Auditable;
    
    protected $table = 'AUDIT_TRAILS';

    protected $primaryKey = 'AUDIT_TRAILS_ID';

    public $timestamps = false;
}
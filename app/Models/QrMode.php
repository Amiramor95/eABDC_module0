<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class QrMode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'QR_MODE';

    protected $primaryKey = 'QR_MODE_ID';

    public $timestamps = false;
}
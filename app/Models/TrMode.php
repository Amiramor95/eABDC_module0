<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrMode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'TR_MODE';

    protected $primaryKey = 'TR_MODE_ID';

    public $timestamps = false;
}
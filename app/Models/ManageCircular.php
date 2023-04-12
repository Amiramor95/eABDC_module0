<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageCircular extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'MANAGE_CIRCULAR';

    protected $primaryKey = 'MANAGE_CIRCULAR_ID';

    public $timestamps = false;
}
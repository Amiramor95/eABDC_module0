<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SmsTac extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'SMS_TAC';

    protected $primaryKey = 'SMS_TAC_ID';

    public $timestamps = false;
}
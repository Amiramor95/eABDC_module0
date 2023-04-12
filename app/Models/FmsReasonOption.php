<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsReasonOption extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_REASON_OPTION';

    protected $primaryKey = 'FMS_REASON_OPTION_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsRemarkOption extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_REMARK_OPTION';

    protected $primaryKey = 'FMS_REMARK_OPTION_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class ConsultantIdMasking extends Model
{
    //use \OwenIt\Auditing\Auditable;
    protected $table = 'CONSULTANT_ID_MASKING_SETTING';

    protected $primaryKey = 'CONSULTANT_MASKING_ID';

    public $timestamps = false;
}
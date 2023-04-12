<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantQualification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_QUALIFICATION';

    protected $primaryKey = 'CONSULTANT_QUALIFICATION_ID';

    public $timestamps = false;
}
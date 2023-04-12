<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantExaminationType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_EXAM_TYPE';

    protected $primaryKey = 'CONSULTANT_EXAM_TYPE_ID';

    public $timestamps = false;
}
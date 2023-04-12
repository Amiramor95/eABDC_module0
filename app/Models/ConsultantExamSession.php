<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantExamSession extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_EXAM_SESSION';

    protected $primaryKey = 'CONSULTANT_EXAM_SESSION_ID';

    public $timestamps = false;
}
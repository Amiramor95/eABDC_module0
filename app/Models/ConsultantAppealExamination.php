<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantAppealExamination extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_APPEAL_EXAMINATION';

    protected $primaryKey = 'CONSULTANT_APPEAL_EXAMINATION_ID';

    public $timestamps = false;
}
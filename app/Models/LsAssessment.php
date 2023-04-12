<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LsAssessment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'LS_ASSESSMENT';

    protected $primaryKey = 'LS_ASSESSMENT_ID';

    public $timestamps = false;
}
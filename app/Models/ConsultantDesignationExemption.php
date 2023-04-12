<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantDesignationExemption extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_DESIGNATION_EXEMPTION';

    protected $primaryKey = 'CONSULTANT_DESIGNATION_EXEMPTION_ID';

    public $timestamps = false;
}
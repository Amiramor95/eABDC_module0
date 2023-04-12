<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantPrsFamiliarisation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_PRS_FAMILIARISATION';

    protected $primaryKey = 'CONSULTANT_PRS_FAMILIARISATION_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantPrsFormerFamiliarisation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_PRS_FORMER_FAMILIARISATION';

    protected $primaryKey = 'CONSULTANT_PRS_FORMER_FAMILIARISATION_ID';

    public $timestamps = false;
}
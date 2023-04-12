<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantBankruptcy extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_BANKRUPTCY';

    protected $primaryKey = 'CONSULTANT_BANKRUPTCY_ID';

    public $timestamps = false;
}
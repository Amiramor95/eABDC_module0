<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantTypeOfApplication extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CONSULTANT_TYPE_OF_APPLICATION';

    protected $primaryKey = 'TYPE_OF_APPLICATION_ID';

    public $timestamps = false;
}
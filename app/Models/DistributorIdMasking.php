<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class DistributorIdMasking extends Model
{
    //use \OwenIt\Auditing\Auditable;
    protected $table = 'DISTRIBUTOR_ID_MASKING_SETTING';

    protected $primaryKey = 'DISTRIBUTOR_MASKING_ID';

    public $timestamps = false;
}
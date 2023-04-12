<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class TrainingProviderIdMasking extends Model
{
    //use \OwenIt\Auditing\Auditable;
    protected $table = 'TRAININGPROVIDER_ID_MASKING_SETTING';

    protected $primaryKey = 'MASKING_ID';

    public $timestamps = false;
}
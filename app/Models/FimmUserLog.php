<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class FimmUserLog extends Model
{
    protected $table = 'FIMM_USER_LOG';

    protected $primaryKey = 'LOG_ID';

    public $timestamps = false;
}
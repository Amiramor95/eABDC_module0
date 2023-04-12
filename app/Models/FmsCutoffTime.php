<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FmsCutoffTime extends Model
{
    protected $table = 'FMS_CUTOFF_TIME';

    protected $primaryKey = 'FMS_CUTOFF_TIME_ID';

    public $timestamps = false;
}
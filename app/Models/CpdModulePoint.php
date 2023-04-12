<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpdModulePoint extends Model
{
    protected $table = 'CPD_HOURS';

    protected $primaryKey = 'CPD_HOURS_ID';

    const CREATED_AT = 'CREATED_TIMESTAMP';
    const UPDATED_AT = 'UPDATED_TIMESTAMP';

    public $timestamps = false;
}
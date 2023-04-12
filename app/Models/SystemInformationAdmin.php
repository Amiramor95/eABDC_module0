<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class SystemInformationAdmin extends Model
{
    protected $table = 'SYSTEM_INFORMATION_ADMIN';

    protected $primaryKey = 'SYSTEM_INFORMATION_ID';

    public $timestamps = false;
}
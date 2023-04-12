<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageSubmodule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'MANAGE_SUBMODULE';
    protected $primaryKey = 'MANAGE_SUBMODULE_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'MANAGE_MODULE';
    protected $primaryKey = 'MANAGE_MODULE_ID';

    public $timestamps = false;
}
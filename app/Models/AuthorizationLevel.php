<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AuthorizationLevel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'AUTHORIZATION_LEVEL';

    protected $primaryKey = 'AUTHORIZATION_LEVEL_ID';

    public $timestamps = false;
}
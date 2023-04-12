<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LoginIdleSession extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'LOGIN_IDLE_SESSION';

    protected $primaryKey = 'LOGIN_IDLE_SESSION_ID';

    public $timestamps = false;
}
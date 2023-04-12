<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PasswordDefault extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'PASSWORD_DEFAULT';

    protected $primaryKey = 'PASSWORD_DEFAULT_ID';

    public $timestamps = false;
}
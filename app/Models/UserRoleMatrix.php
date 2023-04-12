<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserRoleMatrix extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'USER_ROLE_MATRIX';

    protected $primaryKey = 'ROLE_MATRIX_ID';

    public $timestamps = false;
}
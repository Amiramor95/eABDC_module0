<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PasswordHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'PASSWORD_HISTORY';

    protected $primaryKey = 'PASSWORD_HISTORY_ID';

    public $timestamps = false;
}
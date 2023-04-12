<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    protected $table = 'USER_SECURITY_QUESTION';

    protected $primaryKey = 'SECURITY_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'USER_ADDRESS';

    protected $primaryKey = 'USER_ADDRESS_ID';

    public $timestamps = false;
}
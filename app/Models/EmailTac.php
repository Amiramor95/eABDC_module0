<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTac extends Model
{
    protected $connection = 'module0';

    protected $table = 'EMAIL_TAC';

    protected $primaryKey = 'EMAIL_TAC_ID';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingEmail extends Model
{
    protected $table = 'SETTING_EMAIL';

    protected $primaryKey = 'SETTING_EMAIL_ID';

    public $timestamps = false;
}
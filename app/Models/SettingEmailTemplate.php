<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingEmailTemplate extends Model
{
    protected $table = 'SETTING_EMAIL_TEMPLATE';

    protected $primaryKey = 'SETTING_EMAIL_TEMPLATE_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLdap extends Model
{
    protected $table = 'SETTING_LDAP';

    protected $primaryKey = 'SETTING_LDAP_ID';

    public $timestamps = false;
}
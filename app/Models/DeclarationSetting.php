<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeclarationSetting extends Model
{
   // use \OwenIt\Auditing\Auditable;

    protected $table = 'DECLARATION_SETTING';

    protected $primaryKey = 'DECLARATION_SETTING_ID';

    public $timestamps = false;
}
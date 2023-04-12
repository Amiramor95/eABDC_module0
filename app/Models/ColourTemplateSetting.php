<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class ColourTemplateSetting extends Model
{
   // use \OwenIt\Auditing\Auditable;
    protected $table = 'COLOUR_TEMPLATE_SETTING';

    protected $primaryKey = 'COLOUR_SETTING_ID';

    public $timestamps = false;
}
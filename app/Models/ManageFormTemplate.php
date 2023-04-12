<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageFormTemplate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'MANAGE_FORM_TEMPLATE';

    protected $primaryKey = 'MANAGE_FORM_TEMPLATE_ID';

    public $timestamps = false;
}
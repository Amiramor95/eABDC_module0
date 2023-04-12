<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageEventDocument extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'MANAGE_EVENT_DOCUMENT';

    protected $primaryKey = 'MANAGE_EVENT_DOCUMENT_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PageMaintenance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'PAGE_MAINTENANCE';

    protected $primaryKey = 'PAGE_MAINTENANCE_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LsMedia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'LS_MEDIA';

    protected $primaryKey = 'LS_MEDIA_ID';

    public $timestamps = false;
}
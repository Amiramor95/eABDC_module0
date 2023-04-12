<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReadingTrMode extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'READING_TR_MODE';

    protected $primaryKey = 'READING_TR_MODE_ID';

    public $timestamps = false;
}
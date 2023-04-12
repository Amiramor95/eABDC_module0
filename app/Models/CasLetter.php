<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CasLetter extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'CAS_LETTER';

    protected $primaryKey = 'CAS_LETTER_ID';

    public $timestamps = false;
}
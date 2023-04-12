<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FmsFundnotes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'FMS_FUNDNOTES';

    protected $primaryKey = 'FUNDNOTES_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class CpdRevocationApprovalDays extends Model
{

    protected $table = 'CPD_REVOCATION_APPROVAL';

    protected $primaryKey = 'REVOCATION_ID';

    public $timestamps = false;
}
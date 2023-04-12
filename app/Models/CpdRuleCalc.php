<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;

class CpdRuleCalc extends Model
{
    //use \OwenIt\Auditing\Auditable;
    protected $table = 'CPD_RULE_CALC';

    protected $primaryKey = 'CPD_RULE_CALC_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DistributorType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'DISTRIBUTOR_TYPE';

    protected $primaryKey = 'DISTRIBUTOR_TYPE_ID';

    public $timestamps = false;

    public function setSelected($value)
    {
        $this->attributes['selected'] = $value;
    }
}
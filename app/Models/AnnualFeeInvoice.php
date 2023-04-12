<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnnualFeeInvoice extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'ANNUAL_FEE_INVOICE';

    protected $primaryKey = 'ANNUAL_FEE_INVOICE_ID';

    public $timestamps = false;
}
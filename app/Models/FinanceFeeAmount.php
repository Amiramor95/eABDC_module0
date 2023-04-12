<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceFeeAmount extends Model
{
    protected $table = 'FINANCE_FEE_AMOUNT';

    protected $primaryKey = 'FINANCE_FEE_AMOUNT_ID';

    public $timestamps = false;
}
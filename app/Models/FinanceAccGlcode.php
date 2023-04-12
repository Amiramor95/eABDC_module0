<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceAccGlcode extends Model
{
    protected $table = 'FINANCE_CODE';

    protected $primaryKey = 'FINANCE_CODE_ID';

    public $timestamps = false;
}
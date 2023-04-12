<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantBulkUpload extends Model
{

    protected $table = 'CONSULTANT_BULK_UPLOAD';

    protected $primaryKey = 'BULK_ID';

    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileSizeSetting extends Model
{
    protected $table = 'FILE_SIZE_SETTING';

    protected $primaryKey = 'FILE_SIZE_SETTING_ID';

    public $timestamps = false;
}
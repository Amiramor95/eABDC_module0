<?php

namespace App\Models;

use App\ModelFilters\ConsultantFilter;
use App\Models\ConsultantEducation;
use App\Models\SettingGeneral;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $connection = 'module2';

    protected $table = 'CONSULTANT';

    protected $primaryKey = 'CONSULTANT_ID';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManageRequiredDocument extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'MANAGE_REQUIRED_DOCUMENT';

    protected $primaryKey = 'MANAGE_REQUIRED_DOCUMENT_ID';
    //const CREATED_AT = 'CREATE_TIMESTAMP';

    public $timestamps = false;

    public function setFileRecords($value)
    {
        $this->attributes['fileRecords'] = $value;
    }

    public function setFileRecordsForUpload($value)
    {
        $this->attributes['fileRecordsForUpload'] = $value;
    }
}
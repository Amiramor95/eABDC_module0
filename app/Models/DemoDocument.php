<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Encoders\Base64Encoder; //kena letak untuk upload file
class DemoDocument extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $connection= 'demo';
    
    protected $table = 'demo_document';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $attributeModifiers = [
        'doc' => Base64Encoder::class, //kena letak nama column document
    ];
}
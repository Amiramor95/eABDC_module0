<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    protected $connection= 'demo';

    protected $table = 'demo_test';

    public $timestamps =false;
    use HasFactory;

}

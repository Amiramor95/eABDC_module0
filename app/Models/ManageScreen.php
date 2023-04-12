<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageScreen extends Model
{
    protected $table = 'MANAGE_SCREEN';

    protected $primaryKey = 'MANAGE_SCREEN_ID';

    public $timestamps = false;

    protected $quantity = 0;

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($value)
    {
        $this->quantity = $value;
    }

    public function getSelectedAttribute()
    {
        return false;
    }

    public function getIdAttribute()
    {
        static $increment = 0;
        return ++$increment;
    }

    public function custom()
    {
        return false;
    }
}
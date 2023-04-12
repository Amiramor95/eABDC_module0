<?php

namespace App\Helpers;

class Format 
{
}

class ExportExcel
{
    public function format($sheetname,$data) {
        
        $array = array();

        $e = new Format;
        $e->sheet = $sheetname;
        $e->value = $data;

        $array[] = $e;

        return json_encode($array);
    }
}

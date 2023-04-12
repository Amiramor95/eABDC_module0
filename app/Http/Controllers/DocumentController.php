<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function getDocument($filename)
    {

        $token = '';
        if(isset($_COOKIE['fimm-token'])) {
            $token = $_COOKIE['fimm-token'];

            $path = Storage::disk('local')->getAdapter()->getPathPrefix();
            return response()->file($path.'event-document/'.$filename);
        }

    }

}
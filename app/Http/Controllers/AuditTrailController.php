<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Config;
use Auth;

class AuditTrailController extends Controller
{
    public function log($request)
    {
        Route::getCurrentRoute()->getActionName();
        
        try {
        $user = Auth::token();
        $userList = json_decode($user,true);
        $data = new AuditTrail();
        $data->AT_MODULE = config('laradoc.id');
        $data->AT_ACTIVITY = 1;//$request->AT_ACTIVITY;
        $data->CREATE_BY = 1;//$userList['sub'];
        $data->CREATE_TYPE = 1;//$request->CREATE_TYPE;
        $data->AT_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
        $data->AT_DATA_SEND = response()->json($request->all());
        $data->save();
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Log failed.',
                'errorCode' => 4100
            ],400);
        }
    }
}

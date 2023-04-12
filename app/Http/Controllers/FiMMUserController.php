<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use LaravelKeycloakAdmin\Facades\KeycloakAdmin;
use Validator;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Session;
use DB;

class FiMMUserController extends Controller
{
    //
    public function get(Request $request)
    {
        //     return KeycloakAdmin::user()->find([
        //         'query' => [
        //              'username' => $request->login_id
        //         ]
        //    ]);
    }

    public function getAll(Request $request)
    {
        // return KeycloakAdmin::user()->all();
    }
    public function getLoginStatus(Request $request)
    {
        // Log::info("Session Auth=",Session::all());
        //Log::info( "User ID ===>" . $request->USER_ID);
        // Log::info( "User TYPE ===>" . $request->USER_TYPE);
        if ($request->USER_TYPE == 'fimm') {
            $data = DB::table('admin_management.USER AS AUSER')
                ->select('AUSER.ISLOGIN AS ISLOGIN')
                ->where('AUSER.USER_ID', $request->USER_ID)
                ->first();
        }
        if ($request->USER_TYPE == 'DISTRIBUTOR') {
            $data = DB::table('distributor_management.USER AS DUSER')
                ->select('DUSER.ISLOGIN AS ISLOGIN')
                ->where('DUSER.USER_ID', $request->USER_ID)
                ->first();
        }
        //    else
        if ($request->USER_TYPE == 'OTHERS') {
            $data = DB::table('funds_management.TP_USER as TMUSER')
                ->select('TMUSER.ISLOGIN AS ISLOGIN')
                ->where('TMUSER.TP_USER_ID', $request->USER_ID)
                ->first();
        } else if ($request->USER_TYPE == 'ESC') {
            $data = DB::table('exam_booking.ESC_USER as esc')
                ->select('esc.ISLOGIN AS ISLOGIN')
                ->where('esc.ESC_USER_ID', $request->USER_ID)
                ->first();
        }


//        //var_dump($data);
        if ($data->ISLOGIN == 0) {
            $data->ISLOGIN = 1;
            session()->flush();
        }
        http_response_code(200);
        return response([
            'message' => 'User successfully logged in.',
            'data' => $data
            // 'user_name' => $value = session('user_type')
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'string', //dummy1
            'email' => 'string|email' //dummy1@vn.my
        ]);

        // return KeycloakAdmin::user()->all();
    }

    public function delete(Request $request)
    {
        return $request->login_id;
        // return KeycloakAdmin::user()->all();
    }
}

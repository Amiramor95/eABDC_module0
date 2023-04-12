<?php

namespace App\Http\Controllers;

use App\Models\KeycloakSettings;
use App\Models\ManageGroup;
use App\Models\User;
use App\Models\LoginSetting;
use App\Models\SystemBlockDuration;
use App\Models\FimmUserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
// use LaravelKeycloakAdmin\Facades\KeycloakAdmin;
use App\Helpers\CurrentUser;
use Validator;
use Auth;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\ThrottlesLogins;
use App\Models\UserIpBlock;

class AuthController extends Controller
{
    // use ThrottlesLogins;
    // protected $maxAttempts;
    // protected $decayMinutes = 1; // Time for which user is going to be blocked in seconds

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string|max:255', //reg-client
            'username' => 'required|string', //dummy
            'password' => 'required|string' //@Bcd1234
        ]);

        // Default setting for block
        // $loginAttemp = LoginSetting::orderBy('LOGIN_SETTING_ID', 'desc')->first();
        // $blockduration = SystemBlockDuration::orderBy('SYSTEM_BLOCK_DURATION_ID', 'desc')->first();
        // $loginAttempno=$loginAttemp->LOGIN_SETTING_NO;
        // $blockdurationhour=$blockduration->SYSTEM_BLOCK_DURATION_DAYS;
        // $minutes = ($blockdurationhour * 60);
        // $this->maxAttempts = $loginAttempno;
        // $reqthrotle=$this->throttleKey($request);
        // $paramstr= explode("|", $reqthrotle);
        // $blockUserName=$paramstr[0];
        // $blockIp=$paramstr[1];
        // $now = Carbon::now();
        // $request->blockUserName= $blockUserName;
        // $request->blockIp= $blockIp;
        // $request->minutes= $minutes;
        // Check IP Block or NOT

        // $getBlockIP = UserIpBlock::where('USER_NAME', $blockUserName)->where('USER_IP', $blockIp)->where('BLOCK_STATUS', 1)->orderBy('BLOCK_ID', 'desc')->first();
        // if ($getBlockIP) {
        //     $BLOCK_TIME = Carbon::parse($getBlockIP->BLOCK_TIME);

        //     $remainingminute = $BLOCK_TIME->diffInMinutes($now, true);
        //     $blockremainingminute = $minutes-$remainingminute;
        //     Log::info("remainingminute11=".$remainingminute);
        //     if ($remainingminute >= $getBlockIP->BLOCK_DURATION) {
        //         $update=DB::table('admin_management.USER_IP_BLOCK as AMUSERIPBLOCK')->where('AMUSERIPBLOCK.BLOCK_ID', $getBlockIP->BLOCK_ID)->update(['AMUSERIPBLOCK.BLOCK_STATUS' => 0,'AMUSERIPBLOCK.UNBLOCK_TIME' => $now]);
                // $response= $this->loginSucess($request);
            //     return $response;
            // } else {
            //     http_response_code(400);
            //     return response([
            //             'message' => 'Your Account will be unlock after '.$blockremainingminute.' minutes',
            //             'errorCode' => 4003
            //         ], 400);
            // }
        // } else {
            $response= $this->loginSucess($request);
            return $response;
        // }
    }
    public function loginSucess(Request $request)
    {


        $checkLoginId = '';

        // if ($this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);
        //     $slr =  $this->sendLockoutResponse($request);
        //     // USER IP BLOCK
        //     if ($slr == 429) {
        //         $blocktime = Carbon::now();
        //         $blockdata = new UserIpBlock;
        //         $blockdata->USER_NAME = $request->blockUserName;
        //         $blockdata->USER_IP = $request->blockIp;
        //         $blockdata->BLOCK_STATUS = 1;
        //         $blockdata->BLOCK_TIME = $blocktime;
        //         $blockdata->BLOCK_DURATION = $request->minutes;
        //         $blockdata->save();
        //     }
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Too Many Wrong Attempts, Your Account block for '. $request->minutes.' minutes',
        //         'errorCode' => 4003
        //     ], 400);
        //     // return $slr;
        // }

        // if () {

        //     http_response_code(400);
        //     return response([
        //         'message' => 'Invalid login credentials.',
        //         'errorCode' => 4003
        //     ], 400);
        // } else {

            $userdetail = DB::table('admin_management.USER AS user')
            ->join('admin_management.MANAGE_GROUP AS group', 'group.MANAGE_GROUP_ID', '=', 'user.USER_GROUP')
            ->join('admin_management.MANAGE_DEPARTMENT AS department', 'department.MANAGE_DEPARTMENT_ID', '=', 'group.MANAGE_DEPARTMENT_ID')
            ->join('admin_management.MANAGE_DIVISION AS division', 'division.MANAGE_DIVISION_ID', '=', 'department.MANAGE_DIVISION_ID')
            ->where('user.USER_EMAIL', $request->username)
            ->first();

            $USER_NAME = $userdetail->USER_NAME ?? 'undefined';
            $USER_GROUP_NAME = $userdetail->GROUP_NAME ?? 'undefined';
            $USER_GROUP_ID = $userdetail->USER_GROUP ?? 0;
            $USER_ID = $userdetail->USER_ID ?? 0;
            $MANAGE_DEPARTMENT_ID = $userdetail->MANAGE_DEPARTMENT_ID ?? 0;
            $MANAGE_DEPARTMENT_NAME = $userdetail->DPMT_NAME ?? 'undefined';
            $MANAGE_DIVISION_ID = $userdetail->MANAGE_DIVISION_ID ?? 0;
            $MANAGE_DIVISION_NAME = $userdetail->DIV_NAME ?? 'undefined';

            $data = array();
            $data['USER_GROUP_NAME'] = $USER_GROUP_NAME;
            $data['USER_GROUP_ID'] = $USER_GROUP_ID;
            $data['MANAGE_DEPARTMENT_NAME'] = $MANAGE_DEPARTMENT_NAME;
            $data['MANAGE_DEPARTMENT_ID'] = $MANAGE_DEPARTMENT_ID;
            $data['MANAGE_DIVISION_NAME'] = $MANAGE_DIVISION_NAME;
            $data['MANAGE_DIVISION_ID'] = $MANAGE_DIVISION_ID;

            $data['user_id'] = $USER_ID;
            $data['name'] = $USER_NAME;
            $data['user_type'] = 'fimm';
            // Track Idle Session User Group
            $data['PANEL_TRACK'] = 'STAFF';

            //Set session
            session(['user_id' => $USER_ID]);
            session(['name' => $USER_NAME]);
            session(['USER_ID' => $USER_ID]);
            session(['USER_GROUP_NAME' => $USER_GROUP_NAME]);
            session(['GROUP_ID' => $USER_GROUP_ID]);
            session(['MANAGE_DEPARTMENT_NAME' => $MANAGE_DEPARTMENT_NAME]);
            session(['MANAGE_DEPARTMENT_ID' => $MANAGE_DEPARTMENT_ID]);
            session(['MANAGE_DIVISION_NAME' => $MANAGE_DIVISION_NAME]);
            session(['MANAGE_DIVISION_ID' => $MANAGE_DIVISION_ID]);
            session(['MANAGE_DIVISION_ID' => $MANAGE_DIVISION_ID]);
            session(['user_type' => 'fimm']);

            // dd($user);

            // Track Idle Session User Group
            //session(['PANEL_TRACK' => 'STAFF']);

            // Set Last Login Time
            $now = Carbon::now();
            $lastlogtime= $now->format('Y-m-d H:i:s');
            User::where('USER_ID', $USER_ID)
            ->update(['LOGINTIME' =>  $lastlogtime,'LAST_SEEN_AT' =>$lastlogtime,'ISLOGIN' =>1]);
            // Fimm User Log
            // $data_log = new FimmUserLog;
            // $data_log->USER_ID = $USER_ID;
            // $data_log->LOG_IP = $request->blockIp;
            // $data_log->STATUS = 1;
            // $data_log->LOGIN_TIMESTAMP = $lastlogtime;
            // $data_log->save();

            http_response_code(200);
            return response([
                'message' => 'User successfully logged in.',
                'data' => $data
                // 'user_name' => $value = session('user_type')
            ]);
        // }
    }

    public function logout(Request $request)
    {
        $usertype = $request->USER_TYPE;
        $userid = $request->USER_ID;
        //Log::info("Session=",Session::all());
       // Log::info("USER ID1111111=".$userid);
        //Log::info("USER TYPE111111111111=".$usertype);
        try {
            $now = Carbon::now();
            $lastlogtime= $now->format('Y-m-d H:i:s');

            $reqthrotle=$this->throttleKey($request);
            $paramstr= explode("|", $reqthrotle);
            $blockUserName=$paramstr[0];
            $blockIp=$paramstr[1];

            if ($usertype == 'fimm') {
                User::where('USER_ID', $userid)
            ->update(['ISLOGIN' =>0]);

            $getLogIP = FimmUserLog::where('USER_ID', $userid)->where('LOG_IP', $blockIp)->where('STATUS', 1)->orderBy('LOG_ID', 'desc')->first();
            if($getLogIP){
            FimmUserLog::where('USER_ID', $userid)->where('LOG_IP', $blockIp)->where('STATUS', 1)
            ->update(['LOGOUT_TIMESTAMP' =>  $lastlogtime,'STATUS' =>0]);
            }

            }
            if ($usertype == 'DISTRIBUTOR') {
                $updatedata=DB::table('distributor_management.USER as DMUSER')->where('DMUSER.USER_ID', $userid)->update(['DMUSER.ISLOGIN' => 0]);

                $getLogIP1 = DB::table('admin_management.DISTRIBUTOR_USER_LOG AS DISTUSERLOG')->where('DISTUSERLOG.USER_ID', $userid)->where('DISTUSERLOG.LOG_IP', $blockIp)->where('DISTUSERLOG.STATUS', 1)->orderBy('DISTUSERLOG.LOG_ID', 'desc')->first();
                if($getLogIP1){
                   $distlog =  DB::table('admin_management.DISTRIBUTOR_USER_LOG')->where('USER_ID', $userid)->where('LOG_IP', $blockIp)->where('STATUS', 1)
                ->update(['LOGOUT_TIMESTAMP' =>  $lastlogtime,'STATUS' =>0]);
                }

            }
            if ($usertype == 'OTHERS') {
                $updatedata=DB::table('funds_management.TP_USER as TMUSER')->where('TMUSER.TP_USER_ID', $userid)->update(['TMUSER.ISLOGIN' => 0]);

                $getLogIP2 = DB::table('admin_management.OTHERS_USER_LOG AS OTHERUSERLOG')->where('OTHERUSERLOG.USER_ID', $userid)->where('OTHERUSERLOG.LOG_IP', $blockIp)->where('OTHERUSERLOG.STATUS', 1)->orderBy('OTHERUSERLOG.LOG_ID', 'desc')->first();
                if($getLogIP2){
                   $otherlog =  DB::table('admin_management.OTHERS_USER_LOG')->where('USER_ID', $userid)->where('LOG_IP', $blockIp)->where('STATUS', 1)
                ->update(['LOGOUT_TIMESTAMP' =>  $lastlogtime,'STATUS' =>0]);
                }
            }
            if ($usertype == 'ESC') {
                $updatedata1 = DB::table('exam_booking.ESC_USER as ESC_USER')->where('ESC_USER.ESC_USER_ID', $userid)->update(['ESC_USER.ISLOGIN' => 0]);

                $getLogIP2 = DB::table('admin_management.EXAM_BOOKING_USER_LOG AS ESCUSERLOG')->where('ESCUSERLOG.USER_ID', $userid)->where('ESCUSERLOG.LOG_IP', $blockIp)->where('ESCUSERLOG.STATUS', 1)->orderBy('ESCUSERLOG.LOG_ID', 'desc')->first();
                if($getLogIP2){
                   $otherlog =  DB::table('admin_management.EXAM_BOOKING_USER_LOG')->where('USER_ID', $userid)->where('LOG_IP', $blockIp)->where('STATUS', 1)
                ->update(['LOGOUT_TIMESTAMP' =>  $lastlogtime,'STATUS' =>0]);
                }
            }

            //  session()->forget(['keycloak_id', 'user_id', 'name']);
            session()->flush();

            // Log::info("Session Destroy :",Session::all());


            http_response_code(200);
            return response([
                'message' => 'User successfully logged out.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'User failed to log out.',
                'errorCode' => 4004
            ], 400);
        }
    }

    public function checkTokenValidation()
    {
        http_response_code(200);
        return response([
            'message' => 'Token validated.'
        ]);
    }

    public function getTokenInfo()
    {
        http_response_code(200);
        return response([
            'message' => json_decode(Auth::token(), true)
        ]);
    }
}

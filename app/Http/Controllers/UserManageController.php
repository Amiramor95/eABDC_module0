<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\UserAddress;
use App\Models\SettingPassword;
use App\Models\User;
use App\Models\SettingCity;
use App\Models\SettingPostal;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ManageNotification;
use Validator;
use DB;

class UserManageController extends Controller
{
    //Get All City
    public function getAllCity(Request $request)
    {
        try {
            $data = SettingCity::all();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }

    // getAllPostcode
    public function getAllPostcode(Request $request)
    {
        try {
            $data = SettingPostal::all();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }


    public function submitUserRole(Request $request)
    {
        //return $request->all();
        $validator = Validator::make($request->all(), [
                'ADDRESS' => 'required',
                'CITIZEN' => 'required',
                'CITY' => 'required',
                'COUNTRY' => 'required',
                'DEPT_ID' => 'required',
                'DIV_ID' => 'required',
                'PHONE_NUMBER' => 'required',
                'POSTCODE' => 'required',
                'ROLE' => 'required',
                'STATE' => 'required'
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

        try {
                $result = DB::table('USER_ADDRESS')->updateOrInsert(
                    ['USER_ID' =>  $request->USER_ID],
                    [
                        'USER_ADDR_1' => $request->ADDRESS,
                        'USER_COUNTRY' => $request->COUNTRY,
                        'USER_CITY' => $request->CITY,
                        'USER_POSTAL' => $request->COUNTRY,
                        'USER_STATE' => $request->STATE,
                        'USER_ID' =>  $request->USER_ID,
                        'USER_PHONE' => $request->PHONE_NUMBER
                    ]
                );
                if($request->PASSPORT_NUMBER){
                    $result = DB::table('USER_PASSPORT')->updateOrInsert(
                        ['USER_ID' =>  $request->USER_ID],
                        ['USER_PASS_NUM' => $request->PASSPORT_NUMBER ]
                    );

                }
                $user = DB::table('USER')->where('USER_ID',$request->USER_ID)
                        ->update([
                            'USER_STATUS' => 1,
                            'USER_ISLOGIN' => 1,
                            'USER_CITIZEN' => $request->CITIZEN,
                            'USER_GROUP' => $request->GROUP_ID,
                            'USER_ROLE' => $request->ROLE
                         ]);

                // Inser Data to approval table
                $approve = DB::table('USER_APPROVAL')->updateOrInsert(
                    ['USER_ID' =>  $request->USER_ID],
                    ['USER_ROLE' => $request->ROLE]
                );
                // Data sent to notification
                foreach(json_decode($request->APPR_LIST) as $item) {
                    // Notification to HDO
                    $notification = new ManageNotification();
                    $add = $notification->add(
                        $item->APPR_GROUP_ID,
                        $item->APPR_PROCESSFLOW_ID,
                        $request->NOTI_REMARK,
                        $request->NOTI_LOCATION
                    );
                }

                //Save function
                http_response_code(200);
                return response([
                    'message' => 'Data successfully saved.'
                ]);
            } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    // getAllPostcode
    public function getUserManageData(Request $request)
    {       //return $request->all();

        try {
            $userData = DB::table(env('KEYCLOAK_DATABASE').'.USER_ENTITY')
                ->where('EMAIL',$request->USER_EMAIL)->first();
            $data['userData'] =  $userData;

            $userInfo = user::select(
                    '*',
                    'COUNTRY.SET_PARAM AS COUNTRY_NAME',
                    'STATE.SET_PARAM AS STATE_NAME'
                )
                ->leftJoin('USER_ADDRESS AS ADD','ADD.USER_ID','USER.USER_ID')
                ->leftJoin('USER_PASSPORT AS PASS','PASS.USER_ID','USER.USER_ID')
                ->leftJoin('MANAGE_GROUP AS GP','GP.MANAGE_GROUP_ID','USER.USER_GROUP')
                ->leftJoin('MANAGE_DEPARTMENT AS DEPT','DEPT.MANAGE_DEPARTMENT_ID','GP.MANAGE_DEPARTMENT_ID')
                ->leftJoin('MANAGE_DIVISION AS DIV','DIV.MANAGE_DIVISION_ID','DEPT.MANAGE_DIVISION_ID')
                ->leftJoin('SETTING_GENERAL AS COUNTRY','COUNTRY.SETTING_GENERAL_ID','ADD.USER_COUNTRY')
                ->leftJoin('SETTING_GENERAL AS STATE','STATE.SETTING_GENERAL_ID','ADD.USER_STATE')
                ->leftJoin('SETTING_POSTAL AS POSTAL','POSTAL.SETTING_POSTCODE_ID','ADD.USER_POSTAL')
                ->where('USER.USER_ID',$request->USER_ID)
                ->first();
            $data['userInfo'] =  $userInfo;

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }


    // Get all user List
    public function getUserInfo(Request $request)
    {
        $USER_ISLOGIN = 1; // User USER_ISLOGIN 1 Not First
        try {
            $data = user::select('*')
            ->leftJoin('MANAGE_GROUP AS GP','GP.MANAGE_GROUP_ID','USER.USER_GROUP')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT','DEPT.MANAGE_DEPARTMENT_ID','GP.MANAGE_DEPARTMENT_ID')
            ->where('USER.USER_ISLOGIN', $USER_ISLOGIN)
            ->where('DEPT.MANAGE_DEPARTMENT_ID',$request->MANAGE_DEPARTMENT_ID)
            ->get();
            //$data['userInfo'] =  $userInfo;

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }

    // Get all user List
    public function getUserInfoById(Request $request)
    {
        try {
            $data = user::select(
                '*',
                'COUNTRY.SET_PARAM AS COUNTRY_NAME',
                'STATE.SET_PARAM AS STATE_NAME'
            )
            ->leftJoin('USER_ADDRESS AS ADD','ADD.USER_ID','USER.USER_ID')
            ->leftJoin('USER_PASSPORT AS PASS','PASS.USER_ID','USER.USER_ID')
            ->leftJoin('MANAGE_GROUP AS GP','GP.MANAGE_GROUP_ID','USER.USER_GROUP')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT','DEPT.MANAGE_DEPARTMENT_ID','GP.MANAGE_DEPARTMENT_ID')
            ->leftJoin('MANAGE_DIVISION AS DIV','DIV.MANAGE_DIVISION_ID','DEPT.MANAGE_DIVISION_ID')
            ->leftJoin('SETTING_GENERAL AS COUNTRY','COUNTRY.SETTING_GENERAL_ID','ADD.USER_COUNTRY')
            ->leftJoin('SETTING_GENERAL AS STATE','STATE.SETTING_GENERAL_ID','ADD.USER_STATE')
            ->leftJoin('SETTING_POSTAL AS POSTAL','POSTAL.SETTING_POSTCODE_ID','ADD.USER_POSTAL')
            ->leftJoin('USER_APPROVAL AS APPR','APPR.USER_ID','USER.USER_ID')
            ->leftJoin('AUTHORIZATION_LEVEL AS ROLE','ROLE.AUTHORIZATION_LEVEL_ID','APPR.USER_ROLE')
            ->where('USER.USER_ID',$request->USER_ID)
            ->first();
            //$data['userInfo'] =  $userInfo;

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function saveUserApprove(Request $request)
    {
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'APPR_REMARK' => 'required'
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

            try {
                $result = DB::table('USER_APPROVAL')->updateOrInsert(
                    ['USER_ID' =>  $request->USER_ID],
                    [
                        'APPR_REMARK' => $request->APPR_REMARK,
                        'APPR_STATUS' => $request->APPR_STATUS,
                        'USER_GROUP' => $request->USER_GROUP,
                        'APPR_ID' => $request->APPR_ID
                    ]
                );

                $result = DB::table('USER')->where('USER_ID',$request->USER_ID)
                        ->update(['USER_STATUS' => $request->APPR_STATUS ]);


                //Save function
                http_response_code(200);
                return response([
                    'message' => 'Data successfully saved.'
                ]);
            } catch (RequestException $r) {
                http_response_code(400);
                return response([
                    'message' => 'Data failed to be updated.',
                    'errorCode' => 4100
                ],400);
            }

    }









}

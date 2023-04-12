<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManageScreenAccess;
use App\Models\ManageScreen;
use App\Models\UserRoleMatrix;
use App\Models\UserAddress;
use App\Models\User;
use App\Models\SettingCity;
use App\Models\SettingPostal;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ManageNotification;
use Validator;
use DB;

class UserMatrixRoleController extends Controller
{
    
    // Get all user List
    public function getAllUserInfo(Request $request)
    {
        //return $request->all();
        try {
            $data = user::select('*')
                ->leftJoin('MANAGE_GROUP AS GP','GP.MANAGE_GROUP_ID','USER.USER_GROUP')
                ->leftJoin('MANAGE_DEPARTMENT AS DEPT','DEPT.MANAGE_DEPARTMENT_ID','GP.MANAGE_DEPARTMENT_ID')
                ->leftJoin('MANAGE_DIVISION AS DIV','DIV.MANAGE_DIVISION_ID','DEPT.MANAGE_DIVISION_ID')
                ->leftJoin('AUTHORIZATION_LEVEL AS ROLE','ROLE.AUTHORIZATION_LEVEL_ID','USER.USER_ROLE')
                ->where('USER.USER_ISLOGIN',1);
                if($request->divId){
                    $data->where('DIV.MANAGE_DIVISION_ID',$request->divId);
                }
                if($request->deptId){
                    $data->where('DEPT.MANAGE_DEPARTMENT_ID',$request->deptId);
                }
                if($request->grpId){
                    $data->where('GP.MANAGE_GROUP_ID',$request->grpId);
                }
                $data = $data->get();

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

    //Get All 
    public function getUserMatrixScreen(Request $request)
    { 
        //return $request->all();
        try {

            //$matrix = UserRoleMatrix::where('USER_ID',$request->USER_ID)->first();
            // $matrix = DB::table('ADDITIONAL_USER_ACCESS_SCREEN')
            //     ->where('USER_ID', $request->USER_ID)
            //     ->first();
            // if($matrix){
            //     $screen = json_decode($matrix->ADDITIONAL_SCREEN_ID);
            // }else{
            //     $allData = ManageScreenAccess::where('MANAGE_GROUP_ID',$request->MANAGE_GROUP_ID)->first();
            //     $screen = json_decode($allData->MANAGE_SCREEN_ID);
            // }
            
            // Screen for perticular user.......
            $allData = ManageScreenAccess::where('MANAGE_GROUP_ID',$request->MANAGE_GROUP_ID)
                    ->orderBy('MANAGE_SCREEN_ACCESS_ID','DESC')->first();
            
            if($allData->MANAGE_SCREEN_ID == "[0]"){
                $screen = ManageScreen::pluck('MANAGE_SCREEN_ID'); 
            }else{
                $screen1 = ($allData) ? json_decode($allData->MANAGE_SCREEN_ID) : [];

                $matrix = DB::table('ADDITIONAL_USER_ACCESS_SCREEN')
                    ->where('USER_ID', $request->USER_ID)
                    ->first();
                $screen2 = ($matrix) ? json_decode($matrix->ADDITIONAL_SCREEN_ID) : [];    

                $screen = array_merge($screen1,$screen2);   
            }        
            //return $screen1;

            $data = ManageScreen::select('MANAGE_SCREEN.*','MANAGE_SUBMODULE.*','MANAGE_MODULE.*','PROCESS_FLOW.*')
                ->LeftJoin('MANAGE_SUBMODULE','MANAGE_SCREEN.MANAGE_SUBMODULE_ID','MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID')
                ->LeftJoin('MANAGE_MODULE','MANAGE_MODULE.MANAGE_MODULE_ID','MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                ->LeftJoin('PROCESS_FLOW','PROCESS_FLOW.PROCESS_FLOW_ID','MANAGE_SCREEN.SCREEN_PROCESS')
                ->whereIn('MANAGE_SCREEN.MANAGE_SCREEN_ID',$screen)
                ->get();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function saveUserRoleMatrix(Request $request)
    {
        //return $request->all();
        $rules =[];
        if ($request->input('MANAGE_GROUP_ID') == '') {
            $rules['MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('AUTHORIZATION_LEVEL_ID') == '') {
            $rules['AUTHORIZATION_LEVEL_ID'] = 'required|string';
        }
        if($request->input('MANAGE_SCREEN_ID') == '[]'){
            $rules['MANAGE_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {

            $result = DB::table('ADDITIONAL_USER_ACCESS_SCREEN')->updateOrInsert(
                ['USER_ID' =>  $request->USER_ID],
                [
                    'ADDITIONAL_SCREEN_ID' => $request->MANAGE_SCREEN_ID,
                    'CREATE_BY' => $request->CREATE_BY
                ]
            );
            // Change User group & Role
            $user = DB::table('USER')->where('USER_ID',$request->USER_ID)
                ->update([
                    'USER_GROUP' => $request->MANAGE_GROUP_ID,
                    'USER_ROLE' => $request->AUTHORIZATION_LEVEL_ID         
                ]);

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
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

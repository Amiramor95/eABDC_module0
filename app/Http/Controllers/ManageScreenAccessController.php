<?php

namespace App\Http\Controllers;

use App\Models\ManageScreenAccess;
use App\Models\ManageScreen;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class ManageScreenAccessController extends Controller
{
    public function get(Request $request)
    { 
        //return $request->all();
        try {
			//$data = ManageScreenAccess::find($request->MANAGE_SCREEN_ACCESS_ID);

            $data['ScreenAccess'] = ManageScreenAccess::select(
                'MANAGE_SCREEN_ACCESS.*',
                'MANAGE_GROUP.*',
                'MANAGE_DEPARTMENT.*',
                'MANAGE_DIVISION.*',
                'AUTHORIZATION_LEVEL.*',
                'AUTHORIZATION_LEVEL.*',
                'USER.*'
                )
                ->LeftJoin('USER','USER.USER_ID','MANAGE_SCREEN_ACCESS.USER_ID')
                ->LeftJoin('MANAGE_GROUP','MANAGE_GROUP.MANAGE_GROUP_ID','MANAGE_SCREEN_ACCESS.MANAGE_GROUP_ID')
                ->LeftJoin('MANAGE_DEPARTMENT','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
                ->LeftJoin('MANAGE_DIVISION','MANAGE_DIVISION.MANAGE_DIVISION_ID','MANAGE_DEPARTMENT.MANAGE_DIVISION_ID')
                ->LeftJoin('AUTHORIZATION_LEVEL','AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID','MANAGE_SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID')
                ->where('MANAGE_SCREEN_ACCESS.MANAGE_SCREEN_ACCESS_ID',$request->MANAGE_SCREEN_ACCESS_ID)
                ->first();
                
                if($data['ScreenAccess']->MANAGE_SCREEN_ID == '[]' || $data['ScreenAccess']->MANAGE_SCREEN_ID == '[0]'){
                    
                    $data['Screen'] = [];
                    $data['allScreenByModule'] = [];
                    $data['ScreenArr'] = [];
                    $data['allAccess'] = true;
                   
                }else{
                    $arr = substr($data['ScreenAccess']->MANAGE_SCREEN_ID, 1, -1);
                    $arr = explode(',',$arr);
                    //return $arr;

                    $data['Screen'] = ManageScreen::select('MANAGE_SCREEN.*','MANAGE_SUBMODULE.*','MANAGE_MODULE.*','PROCESS_FLOW.*')
                    ->LeftJoin('MANAGE_SUBMODULE','MANAGE_SCREEN.MANAGE_SUBMODULE_ID','MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID')
                    ->LeftJoin('MANAGE_MODULE','MANAGE_MODULE.MANAGE_MODULE_ID','MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                    ->LeftJoin('PROCESS_FLOW','PROCESS_FLOW.PROCESS_FLOW_ID','MANAGE_SCREEN.SCREEN_PROCESS')
                    ->whereIn('MANAGE_SCREEN.MANAGE_SCREEN_ID',$arr)
                    ->get();

                    $subModuleId = $data['Screen'][0]->MANAGE_SUBMODULE_ID ?? '';

                    $data['allScreenByModule'] = ManageScreen::select('*')
                        ->join('MANAGE_SUBMODULE', 
                        'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 
                        'MANAGE_SCREEN.MANAGE_SUBMODULE_ID')
                        ->join('MANAGE_MODULE', 
                        'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 
                        'MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                        ->where('MANAGE_SCREEN.MANAGE_SUBMODULE_ID',$subModuleId)
                        ->get();

                    $data['ScreenArr']  =   $arr;  
                    //$data['allScreenByModule']->append('selected')->toArray();
                    $data['allAccess'] = false;
                }

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
    public function getUser(Request $request)
    {
        try {
			$data = DB::table('USER')
            ->select('*')
            ->get();

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

    public function getAuthorization(Request $request)
    {
        //return $request->all();
        try {
			$data = DB::table('AUTHORIZATION_LEVEL')
            ->select('*')
            ->get();

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
    public function getAllGroup(Request $request)
    {
        try {
			$data = DB::table('MANAGE_GROUP')
            ->select('*')
            ->get();

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
    public function getAll(Request $request)
    { 
        //return $request->all();
        try {
            $data = ManageScreenAccess::select('*')
            ->leftJoin('MANAGE_GROUP', 'MANAGE_GROUP.MANAGE_GROUP_ID', '=', 'MANAGE_SCREEN_ACCESS.MANAGE_GROUP_ID')
            ->leftJoin('AUTHORIZATION_LEVEL', 'AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'MANAGE_SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID')
            ->LeftJoin('MANAGE_DEPARTMENT','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
            ->LeftJoin('MANAGE_DIVISION','MANAGE_DIVISION.MANAGE_DIVISION_ID','MANAGE_DEPARTMENT.MANAGE_DIVISION_ID');
            if($request->MANAGE_DIVISION_ID){
                $data->where('MANAGE_DIVISION.MANAGE_DIVISION_ID',$request->MANAGE_DIVISION_ID);
            }
            if($request->MANAGE_DEPARTMENT_ID){
                $data->where('MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID',$request->MANAGE_DEPARTMENT_ID);
            }
            if($request->MANAGE_GROUP_ID){
                $data->where('MANAGE_GROUP.MANAGE_GROUP_ID',$request->MANAGE_GROUP_ID);
            }
            if($request->TEXT){
                $data->orWhere('MANAGE_GROUP.GROUP_NAME', 'LIKE', '%' . $request->TEXT . '%');
                $data->orWhere('AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_NAME', 'LIKE', '%' . $request->TEXT . '%');
            }
            $data = $data->get();

            $total = $data->count();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data,
                'count' => $total
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function create(Request $request)
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
            $screen = new ManageScreenAccess;
            $screen->MANAGE_GROUP_ID = $request->MANAGE_GROUP_ID;
            $screen->AUTHORIZATION_LEVEL_ID = $request->AUTHORIZATION_LEVEL_ID;
            $screen->MANAGE_SCREEN_ID = $request->MANAGE_SCREEN_ID;
            $screen->USER_ID = $request->USER_ID;
            $screen->save();

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

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'MANAGE_GROUP_ID' => 'required|integer', 
			'AUTHORIZATION_LEVEL_ID' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => ''
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104
            ],400);
        }
    }

    public function update(Request $request)
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
            $data = ManageScreenAccess::find($request->MANAGE_SCREEN_ACCESS_ID);
            $data->MANAGE_GROUP_ID = $request->MANAGE_GROUP_ID;
            $data->AUTHORIZATION_LEVEL_ID = $request->AUTHORIZATION_LEVEL_ID;
            $data->MANAGE_SCREEN_ID = $request->MANAGE_SCREEN_ID;
            $data->USER_ID = $request->$request->USER_ID ?? 0;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ],400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = ManageScreenAccess::find($request->SCREEN_ACCESS_ID);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102
            ],400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'MANAGE_GROUP_ID' => 'required|integer', 
			'AUTHORIZATION_LEVEL_ID' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => 'Filtered data successfully retrieved.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ],400);
        }
    }

    public function userAdditionalScreen(Request $request){
        
        try {
             //return $request->all();
            $screen = DB::table('ADDITIONAL_USER_ACCESS_SCREEN')
            ->where('USER_ID', $request->user_id)
            ->where('SCREEN_ACCESS_ID',$request->screen_id)
            ->first();       
            if($screen){
                $arr = substr($screen->ADDITIONAL_SCREEN_ID, 1, -1);
                $arr = explode(',',$arr);
                //return $arr;

                $data['Screen'] = ManageScreen::select('MANAGE_SCREEN.*','MANAGE_SUBMODULE.*','MANAGE_MODULE.*')
                ->LeftJoin('MANAGE_SUBMODULE','MANAGE_SCREEN.MANAGE_SUBMODULE_ID','MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID')
                ->LeftJoin('MANAGE_MODULE','MANAGE_MODULE.MANAGE_MODULE_ID','MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                ->whereIn('MANAGE_SCREEN.MANAGE_SCREEN_ID',$arr)
                ->get();

            }else{
                $data['Screen'] = [];
            }

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

    public function saveUserAdditionalScreen(Request $request)
    {
        //return $request->all();
        $rules =[];
        if($request->input('ADDITIONAL_SCREEN_ID') == '[]'){
            $rules['ADDITIONAL_SCREEN_ID'] = 'required';
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
                [
                    'USER_ID' => $request->USER_ID,
                    'SCREEN_ACCESS_ID' => $request->SCREEN_ACCESS_ID 
                ],
                [
                    'USER_ID' => $request->USER_ID,
                    'SCREEN_ACCESS_ID' => $request->SCREEN_ACCESS_ID,
                    'ADDITIONAL_SCREEN_ID' => $request->ADDITIONAL_SCREEN_ID,
                    'CREATE_BY' => $request->CREATE_BY
                ],
            );
            http_response_code(200);
            return response([
                'message' => 'Data successfully save.'
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

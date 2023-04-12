<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\DistributorScreenAccess;
use App\Models\DistributorManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class DistributorScreenAccessController extends Controller
{
    public function get(Request $request)
    { 
        //return $request->DISTRIBUTOR_SCREEN_ACCESS_ID;
        try {
            //$data = DistributorScreenAccess::find($request->DISTRIBUTOR_SCREEN_ACCESS_ID);

            $data['ScreenAccess'] = DistributorScreenAccess::select('*')
                ->LeftJoin('USER','USER.USER_ID','DISTRIBUTOR_SCREEN_ACCESS.DISTRIBUTOR_USER_ID')
                ->LeftJoin('DISTRIBUTOR_MANAGE_GROUP','DISTRIBUTOR_MANAGE_GROUP.DISTRIBUTOR_MANAGE_GROUP_ID','DISTRIBUTOR_SCREEN_ACCESS.DISTRIBUTOR_MANAGE_GROUP_ID')
                ->LeftJoin('AUTHORIZATION_LEVEL','AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID','DISTRIBUTOR_SCREEN_ACCESS.DISTRIBUTOR_AUTHORISATION_ID')
                ->where('DISTRIBUTOR_SCREEN_ACCESS.DISTRIBUTOR_SCREEN_ACCESS_ID',$request->DISTRIBUTOR_SCREEN_ACCESS_ID)
                ->first();
                //$screen_id = $data['ScreenAccess']->DISTRIBUTOR_SCREEN_ID ?? '';
                //return $data['ScreenAccess'];
                
                if($data['ScreenAccess']->DISTRIBUTOR_SCREEN_ID == '[]' || $data['ScreenAccess']->DISTRIBUTOR_SCREEN_ID == '[0]' ){
                    $data['Screen'] = [];
                    $data['allScreenByModule'] = [];
                    $data['ScreenArr'] = [];
                    //$data['allScreenByModule']->append('selected')->toArray();
                    $data['allAccess'] = true;
                }else{
                    $arr = substr($data['ScreenAccess']->DISTRIBUTOR_SCREEN_ID, 1, -1);
                    $arr = explode(',',$arr);
                    

                    $data['Screen'] = DistributorManageScreen::select('*')
                    ->LeftJoin('DISTRIBUTOR_MANAGE_SUBMODULE','DISTRIBUTOR_MANAGE_SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID','DISTRIBUTOR_MANAGE_SUBMODULE.DISTRIBUTOR_MANAGE_SUBMODULE_ID')
                    ->LeftJoin('DISTRIBUTOR_MANAGE_MODULE','DISTRIBUTOR_MANAGE_MODULE.DISTRIBUTOR_MANAGE_MODULE_ID','DISTRIBUTOR_MANAGE_SUBMODULE.DISTRIBUTOR_MODULE_ID')
                    ->whereIn('DISTRIBUTOR_MANAGE_SCREEN.DISTRIBUTOR_MANAGE_SCREEN_ID',$arr)
                    ->get();

                    $subModuleId = $data['Screen'][0]->DISTRIBUTOR_MANAGE_SUBMODULE_ID ?? '';

                    $data['allScreenByModule'] = DistributorManageScreen::select('*')
                        ->LeftJoin('DISTRIBUTOR_MANAGE_SUBMODULE', 
                        'DISTRIBUTOR_MANAGE_SUBMODULE.DISTRIBUTOR_MANAGE_SUBMODULE_ID', '=', 
                        'DISTRIBUTOR_MANAGE_SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID')
                        ->LeftJoin('DISTRIBUTOR_MANAGE_MODULE', 
                        'DISTRIBUTOR_MANAGE_MODULE.DISTRIBUTOR_MANAGE_MODULE_ID', '=', 
                        'DISTRIBUTOR_MANAGE_SUBMODULE.DISTRIBUTOR_MODULE_ID')
                        ->where('DISTRIBUTOR_MANAGE_SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID',$subModuleId)
                        ->get();

                    $data['ScreenArr']  =   $arr;
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
    public function getAuthorisationPage(Request $request)
    {
        try {
            $data = DB::table('DISTRIBUTOR_SCREEN_ACCESS AS SCREEN_ACCESS')
            ->select('*')
            ->leftJoin('DISTRIBUTOR_MANAGE_GROUP AS GROUP', 'GROUP.DISTRIBUTOR_MANAGE_GROUP_ID','=', 'SCREEN_ACCESS.DISTRIBUTOR_MANAGE_GROUP_ID')
            ->leftJoin('AUTHORIZATION_LEVEL AS AUTH_LEVEL', 'AUTH_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'SCREEN_ACCESS.DISTRIBUTOR_AUTHORISATION_ID')
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
    public function getAuthLevel(Request $request)
    {
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

    public function getAll()
    {
        try {
            $data = DistributorScreenAccess::select('*')
            ->leftJoin('DISTRIBUTOR_MANAGE_GROUP', 'DISTRIBUTOR_MANAGE_GROUP.DISTRIBUTOR_MANAGE_GROUP_ID', '=', 'DISTRIBUTOR_SCREEN_ACCESS.MANAGE_GROUP_ID')
           ->leftJoin('AUTHORIZATION_LEVEL', 'AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'MANAGE_SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID')
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

    public function create(Request $request)
    {
        //return $request->all();

        // Data Validation 
        $rules =[];
        if ($request->input('DISTRIBUTOR_MANAGE_GROUP_ID') == '') {
            $rules['DISTRIBUTOR_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('DISTRIBUTOR_AUTHORISATION_ID') == '') {
            $rules['DISTRIBUTOR_AUTHORISATION_ID'] = 'required|string';
        }
        if($request->input('DISTRIBUTOR_SCREEN_ID') == '[]'){
            $rules['DISTRIBUTOR_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new DistributorScreenAccess;
            $data->DISTRIBUTOR_MANAGE_GROUP_ID = $request->DISTRIBUTOR_MANAGE_GROUP_ID;
            $data->DISTRIBUTOR_AUTHORISATION_ID = $request->DISTRIBUTOR_AUTHORISATION_ID;
            $data->DISTRIBUTOR_SCREEN_ID = $request->DISTRIBUTOR_SCREEN_ID;
            $data->DISTRIBUTOR_USER_ID = $request->DISTRIBUTOR_USER_ID;
            $data->save();
            //create function

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
			'DISTRIBUTOR_MANAGE_GROUP_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_ID' => 'string|nullable', 
			'DISTRIBUTOR_AUTHORISATION_ID' => 'integer|nullable', 
			'DISTRIBUTOR_USER_ID' => 'integer|nullable' 
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
        // Data Validation 
        $rules =[];
        if ($request->input('DISTRIBUTOR_MANAGE_GROUP_ID') == '') {
            $rules['DISTRIBUTOR_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('DISTRIBUTOR_AUTHORISATION_ID') == '') {
            $rules['DISTRIBUTOR_AUTHORISATION_ID'] = 'required|string';
        }
        if($request->input('DISTRIBUTOR_SCREEN_ID') == '[]'){
            $rules['DISTRIBUTOR_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }
        
        try {
            $data = DistributorScreenAccess::find($request->DISTRIBUTOR_SCREEN_ACCESS_ID);
            $data->DISTRIBUTOR_MANAGE_GROUP_ID = $request->DISTRIBUTOR_MANAGE_GROUP_ID;
            $data->DISTRIBUTOR_AUTHORISATION_ID = $request->DISTRIBUTOR_AUTHORISATION_ID;
            $data->DISTRIBUTOR_SCREEN_ID = $request->DISTRIBUTOR_SCREEN_ID;
            $data->DISTRIBUTOR_USER_ID = $request->DISTRIBUTOR_USER_ID;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated'
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
            $data = DistributorScreenAccess::find($request->DISTRIBUTOR_SCREEN_ACCESS_ID);
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
			'DISTRIBUTOR_MANAGE_GROUP_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_ID' => 'string|nullable', 
			'DISTRIBUTOR_AUTHORISATION_ID' => 'integer|nullable', 
			'DISTRIBUTOR_USER_ID' => 'integer|nullable' 
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
}

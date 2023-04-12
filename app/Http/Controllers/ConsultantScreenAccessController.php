<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ConsultantScreenAccess;
use App\Models\ConsultantManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class ConsultantScreenAccessController extends Controller
{
    public function get(Request $request)
    { 
        //return $request->all();
        try {
            //$data = ConsultantScreenAccess::find($request->CONSULTANT_SCREEN_ACCESS_ID);
            $data['ScreenAccess'] = ConsultantScreenAccess::select('*')
                ->LeftJoin('USER','USER.USER_ID','CONSULTANT_SCREEN_ACCESS.CONSULTANT_USER_ID')
                ->LeftJoin('CONSULTANT_MANAGE_GROUP','CONSULTANT_MANAGE_GROUP.CONSULTANT_MANAGE_GROUP_ID','CONSULTANT_SCREEN_ACCESS.CONSULTANT_MANAGE_GROUP_ID')
                ->LeftJoin('AUTHORIZATION_LEVEL','AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID','CONSULTANT_SCREEN_ACCESS.CONSULTANT_AUTHORISATION_LEVEL_ID')
                ->where('CONSULTANT_SCREEN_ACCESS.CONSULTANT_SCREEN_ACCESS_ID',$request->COSULTANT_SCREEN_ACCESS_ID)
                ->first();
                //$screen_id = $data['ScreenAccess']->CONSULTANT_SCREEN_ID ?? '';
                //return $data['ScreenAccess'];
                
                if($data['ScreenAccess']->CONSULTANT_SCREEN_ID == '[0]' || $data['ScreenAccess']->CONSULTANT_SCREEN_ID == '[]' ){
                    $data['Screen'] = [];
                    $data['allScreenByModule'] = [];
                    $data['ScreenArr'] = [];
                    $data['allAccess'] = true;
                    //$data['allScreenByModule']->append('selected')->toArray();

                }else{
                    
                    $arr = substr($data['ScreenAccess']->CONSULTANT_SCREEN_ID, 1, -1);
                    $arr = explode(',',$arr);
                    
                    $data['Screen'] = ConsultantManageScreen::select('*')
                    ->LeftJoin('CONSULTANT_MANAGE_SUBMODULE','CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID','CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MANAGE_SUBMODULE_ID')
                    ->LeftJoin('CONSULTANT_MANAGE_MODULE','CONSULTANT_MANAGE_MODULE.CONSULTANT_MANAGE_MODULE_ID','CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MODULE_ID')
                    ->whereIn('CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SCREEN_ID',$arr)
                    ->get();

                    $subModuleId = $data['Screen'][0]->CONSULTANT_MANAGE_SUBMODULE_ID ?? '';

                    $data['allScreenByModule'] = ConsultantManageScreen::select('*')
                        ->LeftJoin('CONSULTANT_MANAGE_SUBMODULE', 
                        'CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MANAGE_SUBMODULE_ID', '=', 
                        'CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID')
                        ->LeftJoin('CONSULTANT_MANAGE_MODULE', 
                        'CONSULTANT_MANAGE_MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 
                        'CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MODULE_ID')
                        ->where('CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID',$subModuleId)
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
            $data = DB::table('CONSULTANT_SCREEN_ACCESS AS SCREEN_ACCESS')
            ->select('*')
            ->leftJoin('CONSULTANT_MANAGE_GROUP AS GROUP', 'GROUP.CONSULTANT_MANAGE_GROUP_ID','=', 'SCREEN_ACCESS.CONSULTANT_MANAGE_GROUP_ID')
            ->leftJoin('AUTHORIZATION_LEVEL AS AUTH_LEVEL', 'AUTH_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'SCREEN_ACCESS.CONSULTANT_AUTHORISATION_LEVEL_ID')
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
            $data = ConsultantScreenAccess::select('*')
            ->leftJoin('CONSULTANT_MANAGE_GROUP', 'CONSULTANT_MANAGE_GROUP.CONSULTANT_MANAGE_GROUP_ID', '=', 'CONSULTANT_SCREEN_ACCESS.CONSULTANT_MANAGE_GROUP_ID')
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
        $rules =[];
        if ($request->input('CONSULTANT_MANAGE_GROUP_ID') == '') {
            $rules['CONSULTANT_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('CONSULTANT_AUTHORISATION_LEVEL_ID') == '') {
            $rules['CONSULTANT_AUTHORISATION_LEVEL_ID'] = 'required|string';
        }
        if($request->input('CONSULTANT_SCREEN_ID') == '[]'){
            $rules['CONSULTANT_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }
        

        try {
            $data = new ConsultantScreenAccess;
            $data->CONSULTANT_MANAGE_GROUP_ID = $request->CONSULTANT_MANAGE_GROUP_ID;
            $data->CONSULTANT_AUTHORISATION_LEVEL_ID = $request->CONSULTANT_AUTHORISATION_LEVEL_ID;
            $data->CONSULTANT_SCREEN_ID = $request->CONSULTANT_SCREEN_ID;
            $data->CONSULTANT_USER_ID = $request->CONSULTANT_USER_ID;
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
			'CONSULTANT_MANAGE_GROUP_ID' => 'required|integer', 
			'CONSULTANT_AUTHORISATION_LEVEL_ID' => 'required|integer', 
			'CONSULTANT_SCREEN_ID' => 'required|string', 
			'CONSULTANT_USER_ID' => 'required|integer' 
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
        if ($request->input('CONSULTANT_MANAGE_GROUP_ID') == '') {
            $rules['CONSULTANT_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('CONSULTANT_AUTHORISATION_LEVEL_ID') == '') {
            $rules['CONSULTANT_AUTHORISATION_LEVEL_ID'] = 'required|string';
        }
        if($request->input('CONSULTANT_SCREEN_ID') == '[]'){
            $rules['CONSULTANT_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = ConsultantScreenAccess::find($request->CONSULTANT_SCREEN_ACCESS_ID);
            $data->CONSULTANT_MANAGE_GROUP_ID = $request->CONSULTANT_MANAGE_GROUP_ID;
            $data->CONSULTANT_AUTHORISATION_LEVEL_ID = $request->CONSULTANT_AUTHORISATION_LEVEL_ID;
            $data->CONSULTANT_SCREEN_ID = $request->CONSULTANT_SCREEN_ID;
            $data->CONSULTANT_USER_ID = $request->CONSULTANT_USER_ID;
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
            //return $request->all();
            $data = ConsultantScreenAccess::find($request->CONSULTANT_SCREEN_ACCESS_ID);
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
			'CONSULTANT_MANAGE_GROUP_ID' => 'required|integer', 
			'CONSULTANT_AUTHORISATION_LEVEL_ID' => 'required|integer', 
			'CONSULTANT_SCREEN_ID' => 'required|string', 
			'CONSULTANT_USER_ID' => 'required|integer' 
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

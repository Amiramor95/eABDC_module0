<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\TpScreenAccess;
use App\Models\TpManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class TpScreenAccessController extends Controller
{
    public function get(Request $request)
    {
        try {
            //$data = TpScreenAccess::find($request->TP_SCREEN_ACCESS_ID);

            $data['ScreenAccess'] = TpScreenAccess::select('*')
                ->LeftJoin('USER','USER.USER_ID','TP_SCREEN_ACCESS.TP_USER_ID')
                ->LeftJoin('TP_MANAGE_GROUP','TP_MANAGE_GROUP.TP_MANAGE_GROUP_ID','TP_SCREEN_ACCESS.TP_MANAGE_GROUP_ID')
                ->LeftJoin('AUTHORIZATION_LEVEL','AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID','TP_SCREEN_ACCESS.TP_AUTHORISATION_ID')
                ->where('TP_SCREEN_ACCESS.TP_SCREEN_ACCESS_ID',$request->TP_SCREEN_ACCESS_ID)
                ->first();
                //$screen_id = $data['ScreenAccess']->TP_SCREEN_ID ?? '';
                //return $data['ScreenAccess'];
                
                if($data['ScreenAccess']->TP_MANAGE_SCREEN_ID == '[0]' || $data['ScreenAccess']->TP_MANAGE_SCREEN_ID == '[]' ){
                    $data['Screen'] = [];
                    $data['allScreenByModule'] = [];
                    $data['ScreenArr'] = [];
                    $data['allAccess'] = true;
                }else{
                    
                    $arr = substr($data['ScreenAccess']->TP_MANAGE_SCREEN_ID, 1, -1);
                    $arr = explode(',',$arr);
                    

                    $data['Screen'] = TpManageScreen::select('*')
                    ->LeftJoin('TP_MANAGE_SUBMODULE','TP_MANAGE_SCREEN.TP_MANAGE_SUBMODULE_ID','TP_MANAGE_SUBMODULE.TP_MANAGE_SUBMODULE_ID')
                    ->LeftJoin('TP_MANAGE_MODULE','TP_MANAGE_MODULE.TP_MANAGE_MODULE_ID','TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID')
                    ->whereIn('TP_MANAGE_SCREEN.TP_MANAGE_SCREEN_ID',$arr)
                    ->get();

                    $subModuleId = $data['Screen'][0]->TP_MANAGE_SUBMODULE_ID ?? '';

                    $data['allScreenByModule'] = TpManageScreen::select('*')
                        ->LeftJoin('TP_MANAGE_SUBMODULE', 
                        'TP_MANAGE_SUBMODULE.TP_MANAGE_SUBMODULE_ID', '=', 
                        'TP_MANAGE_SCREEN.TP_MANAGE_SUBMODULE_ID')
                        ->LeftJoin('TP_MANAGE_MODULE', 
                        'TP_MANAGE_MODULE.TP_MANAGE_MODULE_ID', '=', 
                        'TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID')
                        ->where('TP_MANAGE_SCREEN.TP_MANAGE_SUBMODULE_ID',$subModuleId)
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
            $data = DB::table('TP_SCREEN_ACCESS AS SCREEN_ACCESS')
            ->select('*')
            ->leftJoin('TP_MANAGE_GROUP AS GROUP', 'GROUP.TP_MANAGE_GROUP_ID','=', 'SCREEN_ACCESS.TP_MANAGE_GROUP_ID')
            ->leftJoin('AUTHORIZATION_LEVEL AS AUTH_LEVEL', 'AUTH_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'SCREEN_ACCESS.TP_AUTHORISATION_ID')
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
            $data = TpScreenAccess::select('*')
            ->leftJoin('TP_MANAGE_GROUP', 'TP_MANAGE_GROUP.TP_MANAGE_GROUP_ID', '=', 'TP_SCREEN_ACCESS.MANAGE_GROUP_ID')
           ->leftJoin('AUTHORIZATION_LEVEL', 'AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'TP_SCREEN_ACCESS.AUTHORISATION_ID')
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

        $rules =[];
        if ($request->input('TP_MANAGE_GROUP_ID') == '') {
            $rules['TP_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('TP_AUTHORISATION_ID') == '') {
            $rules['TP_AUTHORISATION_ID'] = 'required|string';
        }
        if($request->input('TP_MANAGE_SCREEN_ID') == '[]'){
            $rules['TP_MANAGE_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new TpScreenAccess;
            $data->TP_MANAGE_GROUP_ID = $request->TP_MANAGE_GROUP_ID;
            $data->TP_AUTHORISATION_ID = $request->TP_AUTHORISATION_ID;
            $data->TP_MANAGE_SCREEN_ID = $request->TP_MANAGE_SCREEN_ID;
            $data->TP_USER_ID = $request->TP_USER_ID;
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
			'TP_MANAGE_GROUP_ID' => 'integer|nullable', 
			'TP_AUTHORISATION_ID' => 'integer|nullable', 
			'TP_MANAGE_SCREEN_ID' => 'string|nullable', 
			'TP_USER_ID' => 'required|integer' 
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
        //return $request->TP_SCREEN_ACCESS_ID;
        $rules =[];
        if ($request->input('TP_MANAGE_GROUP_ID') == '') {
            $rules['TP_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('TP_AUTHORISATION_ID') == '') {
            $rules['TP_AUTHORISATION_ID'] = 'required|string';
        }
        if($request->input('TP_MANAGE_SCREEN_ID') == '[]'){
            $rules['TP_MANAGE_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = TpScreenAccess::find($request->TP_SCREEN_ACCESS_ID);
            $data->TP_AUTHORISATION_ID = $request->TP_AUTHORISATION_ID;
            $data->TP_MANAGE_SCREEN_ID = $request->TP_MANAGE_SCREEN_ID;
            $data->TP_USER_ID = $request->TP_USER_ID;
            $data->TP_MANAGE_GROUP_ID = $request->TP_MANAGE_GROUP_ID;
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
            $data = TpScreenAccess::find($request->TP_SCREEN_ACCESS_ID);
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
			'TP_MANAGE_GROUP_ID' => 'integer|nullable', 
			'TP_AUTHORISATION_ID' => 'integer|nullable', 
			'TP_MANAGE_SCREEN_ID' => 'string|nullable', 
			'TP_USER_ID' => 'required|integer' 
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ThirdpartyScreenAccess;
use App\Models\ThirdPartyManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class ThirdpartyScreenAccessController extends Controller
{
    public function get(Request $request)
    {
        //return $request->all();
        try {
            //$data = ThirdpartyScreenAccess::find($request->THIRDPARTY_SCREEN_ACCESS_ID);

            $data['ScreenAccess'] = ThirdpartyScreenAccess::select('*')
                ->LeftJoin('USER','USER.USER_ID','THIRDPARTY_SCREEN_ACCESS.THIRDPARTY_USER_ID')
                ->LeftJoin('THIRDPARTY_MANAGE_GROUP','THIRDPARTY_MANAGE_GROUP.THIRDPARTY_MANAGE_GROUP_ID','THIRDPARTY_SCREEN_ACCESS.THIRDPARTY_MANAGE_GROUP_ID')
                ->LeftJoin('AUTHORIZATION_LEVEL','AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID','THIRDPARTY_SCREEN_ACCESS.THIRDPARTY_AUTHORISATION_LEVEL_ID')
                ->where('THIRDPARTY_SCREEN_ACCESS.THIRDPARTY_SCREEN_ACCESS_ID',$request->THIRDPARTY_SCREEN_ACCESS_ID)
                ->first();
                //$screen_id = $data['ScreenAccess']->THIRDPARTY_SCREEN_ID ?? '';
                //return $data['ScreenAccess'];
                
                if($data['ScreenAccess']->THIRDPARTY_SCREEN_ID == '[0]' || $data['ScreenAccess']->THIRDPARTY_SCREEN_ID == '[]' ){
                    $data['Screen'] = [];
                    $data['allScreenByModule'] = [];
                    $data['ScreenArr'] = [];
                    $data['allAccess'] = true;
                }else{
                    
                    $arr = substr($data['ScreenAccess']->THIRDPARTY_SCREEN_ID, 1, -1);
                    $arr = explode(',',$arr);
                    
                    $data['Screen'] = ThirdpartyManageScreen::select('*')
                    ->LeftJoin('THIRDPARTY_SUBMODULE','THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_SUBMODULE_ID','THIRDPARTY_SUBMODULE.THIRDPARTY_SUBMODULE_ID')
                    ->LeftJoin('THIRDPARTY_MANAGE_MODULE','THIRDPARTY_MANAGE_MODULE.THIRDPARTY_MANAGE_MODULE_ID','THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID')
                    ->whereIn('THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_MANAGE_SCREEN_ID',$arr)
                    ->get();

                    $subModuleId = $data['Screen'][0]->THIRDPARTY_SUBMODULE_ID ?? '';

                    $data['allScreenByModule'] = ThirdpartyManageScreen::select('*')
                        ->LeftJoin('THIRDPARTY_SUBMODULE', 
                        'THIRDPARTY_SUBMODULE.THIRDPARTY_SUBMODULE_ID', '=', 
                        'THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_SUBMODULE_ID')
                        ->LeftJoin('THIRDPARTY_MANAGE_MODULE', 
                        'THIRDPARTY_MANAGE_MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 
                        'THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID')
                        ->where('THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_SUBMODULE_ID',$subModuleId)
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
            $data = DB::table('THIRDPARTY_SCREEN_ACCESS AS SCREEN_ACCESS')
            ->select('*')
            ->leftJoin('THIRDPARTY_MANAGE_GROUP AS GROUP', 'GROUP.THIRDPARTY_MANAGE_GROUP_ID','=', 'SCREEN_ACCESS.THIRDPARTY_MANAGE_GROUP_ID')
            ->leftJoin('AUTHORIZATION_LEVEL AS AUTH_LEVEL', 'AUTH_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'SCREEN_ACCESS.THIRDPARTY_AUTHORISATION_LEVEL_ID')
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
            $data = ThirdpartyScreenAccess::select('*')
            ->leftJoin('THIRDPARTY_MANAGE_GROUP', 'THIRDPARTY_MANAGE_GROUP.THIRDPARTY_MANAGE_GROUP_ID', '=', 'THIRDPARTY_SCREEN_ACCESS.MANAGE_GROUP_ID')
           ->leftJoin('AUTHORIZATION_LEVEL', 'AUTHORIZATION_LEVEL.AUTHORIZATION_LEVEL_ID', '=', 'THIRDPARTY_SCREEN_ACCESS.THIRDPARTY_AUTHORISATION_LEVEL_ID')
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
        if ($request->input('THIRDPARTY_MANAGE_GROUP_ID') == '') {
            $rules['THIRDPARTY_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('THIRDPARTY_AUTHORISATION_LEVEL_ID') == '') {
            $rules['THIRDPARTY_AUTHORISATION_LEVEL_ID'] = 'required|string';
        }
        if($request->input('THIRDPARTY_SCREEN_ID') == '[]'){
            $rules['THIRDPARTY_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }
    
        try {
            $data = new ThirdpartyScreenAccess;
            $data->THIRDPARTY_MANAGE_GROUP_ID = $request->THIRDPARTY_MANAGE_GROUP_ID;
            $data->THIRDPARTY_AUTHORISATION_LEVEL_ID = $request->THIRDPARTY_AUTHORISATION_LEVEL_ID;
            $data->THIRDPARTY_SCREEN_ID = $request->THIRDPARTY_SCREEN_ID;
            $data->THIRDPARTY_USER_ID = $request->THIRDPARTY_USER_ID;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully create.'
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
			'THIRDPARTY_MANAGE_GROUP_ID' => 'required|integer', 
			'THIRDPARTY_AUTHORISATION_LEVEL_ID' => 'required|integer', 
			'THIRDPARTY_SCREEN_ID' => 'required|string', 
			'THIRDPARTY_USER_ID' => 'required|integer' 
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
        if ($request->input('THIRDPARTY_MANAGE_GROUP_ID') == '') {
            $rules['THIRDPARTY_MANAGE_GROUP_ID'] = 'required|string';
        }
        if($request->input('THIRDPARTY_AUTHORISATION_LEVEL_ID') == '') {
            $rules['THIRDPARTY_AUTHORISATION_LEVEL_ID'] = 'required|string';
        }
        if($request->input('THIRDPARTY_SCREEN_ID') == '[]'){
            $rules['THIRDPARTY_SCREEN_ID'] = 'required';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = ThirdpartyScreenAccess::find($request->THIRDPARTY_SCREEN_ACCESS_ID);
            $data->THIRDPARTY_MANAGE_GROUP_ID = $request->THIRDPARTY_MANAGE_GROUP_ID;
            $data->THIRDPARTY_AUTHORISATION_LEVEL_ID = $request->THIRDPARTY_AUTHORISATION_LEVEL_ID;
            $data->THIRDPARTY_SCREEN_ID = $request->THIRDPARTY_SCREEN_ID;
            $data->THIRDPARTY_USER_ID = $request->THIRDPARTY_USER_ID;
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
            $data = ThirdpartyScreenAccess::find($request->THIRDPARTY_SCREEN_ACCESS_ID);
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
			'THIRDPARTY_MANAGE_GROUP_ID' => 'required|integer', 
			'THIRDPARTY_AUTHORISATION_LEVEL_ID' => 'required|integer', 
			'THIRDPARTY_SCREEN_ID' => 'required|string', 
			'THIRDPARTY_USER_ID' => 'required|integer' 
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

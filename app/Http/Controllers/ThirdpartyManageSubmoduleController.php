<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ThirdpartyManageSubmodule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB; 

class ThirdpartyManageSubmoduleController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ThirdpartyManageSubmodule::select('*')
            ->leftJoin(
                'THIRDPARTY_MANAGE_MODULE AS MANAGE_MODULE',
                'MANAGE_MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 
                'THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID'
                )
            ->find($request->THIRDPARTY_SUBMODULE_ID);

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
    public function getThirdModule(Request $request)
    {
        try {
            $data = DB::table('THIRDPARTY_MANAGE_MODULE')
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
            $data = DB::table('THIRDPARTY_SUBMODULE')
            ->select('*')
            ->leftJoin('THIRDPARTY_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 'THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID')
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

    public function getByModule(Request $request)
    {
        try {
            $data = DB::table('THIRDPARTY_SUBMODULE')
            ->where('THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID',$request->THIRDPARTY_MANAGE_MODULE_ID)
            //->leftJoin('THIRDPARTY_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 'THIRDPARTY_SUBMODULE.THIRDPARTY_MANAGE_MODULE_ID')
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
        $validator = Validator::make($request->all(), [ 
            'THIRDPARTY_SUBMOD_CODE' => 'required', 
            'THIRDPARTY_SUBMOD_NAME' => 'required', 
            'THIRDPARTY_MANAGE_MODULE_ID' => 'required'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new ThirdpartyManageSubmodule;
            $data->THIRDPARTY_SUBMOD_CODE = strtoupper($request->THIRDPARTY_SUBMOD_CODE);
            $data->THIRDPARTY_SUBMOD_NAME = strtoupper($request->THIRDPARTY_SUBMOD_NAME);
            $data->THIRDPARTY_MANAGE_MODULE_ID = $request->THIRDPARTY_MANAGE_MODULE_ID;
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
        $validator = Validator::make($request->all(), [ //fresh
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
                'message' => 'Data successfully updated.',
                'errorCode' => 4104
            ],400);
        }
    }

    public function update(Request $request)
    { 
        //return $request->all();
        try {
            
            $validator = Validator::make($request->all(), [ 
                'THIRDPARTY_SUBMOD_CODE' => 'required', 
                'THIRDPARTY_SUBMOD_NAME' => 'required', 
                'THIRDPARTY_MANAGE_MODULE_ID' => 'required'
            ]);
    
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                    'message' => 'Data validation error.',
                    'errorCode' => 4106
                ],400);
            }

            $data = ThirdpartyManageSubmodule::find($request->THIRDPARTY_MANAGE_SUBMODULE_ID);
            $data->THIRDPARTY_SUBMOD_CODE = strtoupper($request->THIRDPARTY_SUBMOD_CODE);
            $data->THIRDPARTY_SUBMOD_NAME = strtoupper($request->THIRDPARTY_SUBMOD_NAME);
            $data->THIRDPARTY_MANAGE_MODULE_ID = $request->THIRDPARTY_MANAGE_MODULE_ID;
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
            $data = ThirdpartyManageSubmodule::find($request->THIRDPARTY_SUBMODULE_ID);
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
        $validator = Validator::make($request->all(), [ //fresh
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

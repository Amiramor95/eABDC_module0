<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\TpManageSubmodule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class TpManageSubmoduleController extends Controller
{
    public function get(Request $request)
    {
        try { //return $request->all();
            $data = TpManageSubmodule::select('*')
            ->leftJoin('TP_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.TP_MANAGE_MODULE_ID', '=', 'TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID')
            ->find($request->TP_SUBMODULE_ID);

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
            $data = DB::table('TP_MANAGE_MODULE')
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
            $data = DB::table('TP_MANAGE_SUBMODULE')
            ->select('*')
            ->leftJoin('TP_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.TP_MANAGE_MODULE_ID', '=', 'TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID')
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
            $data = DB::table('TP_MANAGE_SUBMODULE')
            ->where('TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID',$request->TP_MANAGE_MODULE_ID)
            //->leftJoin('TP_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.TP_MANAGE_MODULE_ID', '=', 'TP_MANAGE_SUBMODULE.TP_MANAGE_MODULE_ID')
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
			'TP_MANAGE_MODULE_ID' => 'required', 
			'TP_SUBMOD_CODE' => 'required', 
			'TP_SUBMOD_NAME' => 'required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }
        
        try {
            $data = new TpManageSubmodule;
            $data->TP_SUBMOD_CODE = strtoupper($request->TP_SUBMOD_CODE);
            $data->TP_SUBMOD_NAME = strtoupper($request->TP_SUBMOD_NAME);
            $data->TP_MANAGE_MODULE_ID = $request->TP_MANAGE_MODULE_ID;
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
			'TP_MANAGE_MODULE_ID' => 'required', 
			'TP_SUBMOD_CODE' => 'required', 
			'TP_SUBMOD_NAME' => 'required' 
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
        $validator = Validator::make($request->all(), [ 
			'TP_MANAGE_MODULE_ID' => 'required', 
			'TP_SUBMOD_CODE' => 'required', 
			'TP_SUBMOD_NAME' => 'required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = TpManageSubmodule::find($request->TP_MANAGE_SUBMODULE_ID);
            $data->TP_SUBMOD_CODE = strtoupper($request->TP_SUBMOD_CODE);
            $data->TP_SUBMOD_NAME = strtoupper($request->TP_SUBMOD_NAME);
            $data->TP_MANAGE_MODULE_ID = $request->TP_MANAGE_MODULE_ID;
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
        //return $request->all();
        try {
            $data = TpManageSubmodule::find($request->TP_SUBMODULE_ID);
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
			'TP_MANAGE_MODULE_ID' => 'integer|nullable', 
			'TP_SUBMOD_CODE' => 'string|nullable', 
			'TP_SUBMOD_NAME' => 'string|nullable' 
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ConsultantManageSubmodule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class ConsultantManageSubmoduleController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantManageSubmodule::select('*')
            ->leftJoin('CONSULTANT_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 'CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MODULE_ID')
            ->find($request->CONSULTANT_MANAGE_SUBMODULE_ID);

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
    public function getConsModule(Request $request)
    {
        try {
            $data = DB::table('CONSULTANT_MANAGE_MODULE')
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
            $data = DB::table('CONSULTANT_MANAGE_SUBMODULE')
            ->select('*')
            ->leftJoin('CONSULTANT_MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 'CONSULTANT_MANAGE_SUBMODULE.CONSULTANT_MODULE_ID')
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

    public function getSubmoduleByModule(Request $request)
    {
        try {
            $data = DB::table('CONSULTANT_MANAGE_SUBMODULE')
            ->where('CONSULTANT_MODULE_ID',$request->CONSULTANT_MANAGE_MODULE_ID)
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
			'CONSULTANT_SUBMODULE_CODE' => 'required|string', 
			'CONSULTANT_SUBMODULE_NAME' => 'required|string', 
			'CONSULTANT_MODULE_ID' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }
    
        try {
            $data = new ConsultantManageSubmodule;
            $data->CONSULTANT_SUBMODULE_CODE = strtoupper($request->CONSULTANT_SUBMODULE_CODE);
            $data->CONSULTANT_SUBMODULE_NAME = strtoupper($request->CONSULTANT_SUBMODULE_NAME);
            $data->CONSULTANT_MODULE_ID = $request->CONSULTANT_MODULE_ID;
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
			'CONSULTANT_SUBMODULE_CODE' => 'required|string', 
			'CONSULTANT_SUBMODULE_NAME' => 'required|string', 
			'CONSULTANT_MODULE_ID' => 'required|integer' 
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
			'CONSULTANT_SUBMODULE_CODE' => 'required|string', 
			'CONSULTANT_SUBMODULE_NAME' => 'required|string', 
			'CONSULTANT_MODULE_ID' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = ConsultantManageSubmodule::find($request->CONSULTANT_MANAGE_SUBMODULE_ID);
            $data->CONSULTANT_SUBMODULE_CODE = strtoupper($request->CONSULTANT_SUBMODULE_CODE);
            $data->CONSULTANT_SUBMODULE_NAME = strtoupper($request->CONSULTANT_SUBMODULE_NAME);
            $data->CONSULTANT_MODULE_ID = $request->CONSULTANT_MODULE_ID;
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
            $data = ConsultantManageSubmodule::find($request->CONSULTANT_MANAGE_SUBMODULE_ID);
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
			'CONSULTANT_SUBMODULE_CODE' => 'required|string', 
			'CONSULTANT_SUBMODULE_NAME' => 'required|string', 
			'CONSULTANT_MODULE_ID' => 'required|integer' 
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

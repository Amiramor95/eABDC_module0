<?php

namespace App\Http\Controllers;

use App\Models\ManageSubmodule;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class ManageSubmoduleController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = ManageSubmodule::where('MANAGE_MODULE_ID',$request->MANAGE_MODULE_ID)->get(); 

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

    public function getSubmodule(Request $request)
    {
        try {
			$data = ManageSubmodule::select('*')
            ->join('MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_SUBMODULE.MANAGE_MODULE_ID')
            ->find($request->MANAGE_SUBMODULE_ID); 

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
            $data = ManageSubmodule::all();


            $data = ManageSubmodule::select('*')
            ->join('MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_SUBMODULE.MANAGE_MODULE_ID')->get();

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
    public function getAllSubRequire()
    {
        try {
            $data = ManageSubmodule::get();


            // $data = ManageSubmodule::select('*')
            // ->join('MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_SUBMODULE.MANAGE_MODULE_ID')->get();

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
			'MANAGE_MODULE_ID' => 'required|integer', 
			'SUBMOD_CODE' => 'required|string', 
			'SUBMOD_NAME' => 'required|string' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $module = new ManageSubmodule;
            $module->MANAGE_MODULE_ID = $request->MANAGE_MODULE_ID;
            $module->SUBMOD_CODE = $request->SUBMOD_CODE;
            $module->SUBMOD_NAME = $request->SUBMOD_NAME;
            $module->save();

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
			'MANAGE_MODULE_ID' => 'required|integer', 
			'SUBMOD_CODE' => 'required|string', 
			'SUBMOD_NAME' => 'required|string' 
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
			'MANAGE_MODULE_ID' => 'required|integer', 
			'SUBMOD_CODE' => 'required|string', 
			'SUBMOD_NAME' => 'required|string' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $module = ManageSubmodule::find($request->MANAGE_SUBMODULE_ID);
            $module->MANAGE_MODULE_ID = $request->MANAGE_MODULE_ID;
            $module->SUBMOD_CODE = $request->SUBMOD_CODE;
            $module->SUBMOD_NAME = $request->SUBMOD_NAME;
            $module->save();

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
            $data = ManageSubmodule::find($request->MANAGE_SUBMODULE_ID);
            $data->delete();

            // if (data == null){
            // $data = ManageSubmodule::find($request->MANAGE_SUBMODULE);
            // $data->delete();
            // }

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
			'MANAGE_MODULE_ID' => 'required|integer', 
			'SUBMOD_CODE' => 'required|string', 
			'SUBMOD_NAME' => 'required|string' 
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

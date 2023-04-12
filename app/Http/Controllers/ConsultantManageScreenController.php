<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ConsultantManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rule;

class ConsultantManageScreenController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantManageScreen::select('*')
            ->leftJoin('CONSULTANT_MANAGE_MODULE AS MODULE', 'MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 'CONSULTANT_MANAGE_SCREEN.CONSULTANT_MODULE_ID')
            ->leftJoin('CONSULTANT_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.CONSULTANT_MANAGE_SUBMODULE_ID', '=', 'CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'CONSULTANT_MANAGE_SCREEN.CONSULTANT_SCREEN_PROCESS_ID')
            ->where('CONSULTANT_MANAGE_SCREEN.CONSULTANT_MANAGE_SCREEN_ID',$request->CONSULTANT_MANAGE_SCREEN_ID)
            ->first();

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
            $data = DB::table('CONSULTANT_MANAGE_SUBMODULE')
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
    public function getProcessFlow(Request $request)
    {
        try {
            $data = DB::table('PROCESS_FLOW')
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
            $data = DB::table('CONSULTANT_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.CONSULTANT_MOD_NAME AS MOD_NAME')
            ->leftJoin('CONSULTANT_MANAGE_MODULE AS MODULE', 'MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 'SCREEN.CONSULTANT_MODULE_ID')
            ->leftJoin('CONSULTANT_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.CONSULTANT_MANAGE_SUBMODULE_ID', '=', 'SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.CONSULTANT_SCREEN_PROCESS_ID')
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
            $data = DB::table('CONSULTANT_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.CONSULTANT_MOD_NAME AS MOD_NAME')
            ->leftJoin('CONSULTANT_MANAGE_MODULE AS MODULE', 'MODULE.CONSULTANT_MANAGE_MODULE_ID', '=', 'SCREEN.CONSULTANT_MODULE_ID')
            ->leftJoin('CONSULTANT_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.CONSULTANT_MANAGE_SUBMODULE_ID', '=', 'SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.CONSULTANT_SCREEN_PROCESS_ID');
            if($request->CONSULTANT_MANAGE_MODULE_ID){
                $data->where('SCREEN.CONSULTANT_MODULE_ID',$request->CONSULTANT_MANAGE_MODULE_ID);
            }
            if($request->CONSULTANT_MANAGE_SUBMODULE_ID){
                $data->where('SCREEN.CONSULTANT_MANAGE_SUBMODULE_ID',$request->CONSULTANT_MANAGE_SUBMODULE_ID);
            }
            $data = $data->get();
            

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
    { //return $request->all();

        // Server side validation
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'CONSULTANT_SCREEN_CODE' => 'required|unique:CONSULTANT_MANAGE_SCREEN',
			'CONSULTANT_MODULE_ID' => 'required', 
			'CONSULTANT_MANAGE_SUBMODULE_ID' => 'required', 
			'CONSULTANT_SCREEN_NAME' => 'required', 
			'CONSULTANT_SCREEN_ROUTE' => 'required', 
			'CONSULTANT_SCREEN_PROCESS_ID' => 'required', 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
        

        try {
            $data = new ConsultantManageScreen;
            $data->CONSULTANT_MODULE_ID = $request->CONSULTANT_MODULE_ID;
            $data->CONSULTANT_MANAGE_SUBMODULE_ID = $request->CONSULTANT_MANAGE_SUBMODULE_ID;
            $data->CONSULTANT_SCREEN_PROCESS_ID = $request->CONSULTANT_SCREEN_PROCESS_ID;
            $data->CONSULTANT_SCREEN_NAME = strtoupper($request->CONSULTANT_SCREEN_NAME);
            $data->CONSULTANT_SCREEN_ROUTE = ($request->CONSULTANT_SCREEN_ROUTE);
            $data->CONSULTANT_SCREEN_DESC = strtoupper($request->CONSULTANT_SCREEN_DESC);
            $data->CONSULTANT_SCREEN_CODE = strtoupper($request->CONSULTANT_SCREEN_CODE);
            
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
			'CONSULTANT_MODULE_ID' => 'integer|nullable', 
			'CONSULTANT_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'CONSULTANT_SCREEN_NAME' => 'string|nullable', 
			'CONSULTANT_SCREEN_ROUTE' => 'string|nullable', 
			'CONSULTANT_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'CONSULTANT_SCREEN_DESC' => 'string|nullable' 
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

        // Server side validation
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'CONSULTANT_SCREEN_CODE' => ['required',Rule::unique('CONSULTANT_MANAGE_SCREEN')
            ->where(function ($query) use ($request) {
                return $query->where('CONSULTANT_MANAGE_SCREEN_ID', '!=',  $request->CONSULTANT_MANAGE_SCREEN_ID);
            })],
			'CONSULTANT_MODULE_ID' => 'required', 
			'CONSULTANT_MANAGE_SUBMODULE_ID' => 'required', 
			'CONSULTANT_SCREEN_NAME' => 'required', 
			'CONSULTANT_SCREEN_ROUTE' => 'required', 
			'CONSULTANT_SCREEN_PROCESS_ID' => 'required', 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $data = ConsultantManageScreen::find($request->CONSULTANT_MANAGE_SCREEN_ID);
            $data->CONSULTANT_MODULE_ID = $request->CONSULTANT_MODULE_ID;
            $data->CONSULTANT_MANAGE_SUBMODULE_ID = $request->CONSULTANT_MANAGE_SUBMODULE_ID;
            $data->CONSULTANT_SCREEN_PROCESS_ID = $request->CONSULTANT_SCREEN_PROCESS_ID;
            $data->CONSULTANT_SCREEN_NAME = strtoupper($request->CONSULTANT_SCREEN_NAME);
            $data->CONSULTANT_SCREEN_ROUTE = ($request->CONSULTANT_SCREEN_ROUTE);
            $data->CONSULTANT_SCREEN_DESC = strtoupper($request->CONSULTANT_SCREEN_DESC);
            $data->CONSULTANT_SCREEN_CODE = strtoupper($request->CONSULTANT_SCREEN_CODE);
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
            $data = ConsultantManageScreen::find($request->CONSULTANT_MANAGE_SCREEN_ID);
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
			'CONSULTANT_MODULE_ID' => 'integer|nullable', 
			'CONSULTANT_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'CONSULTANT_SCREEN_NAME' => 'string|nullable', 
			'CONSULTANT_SCREEN_ROUTE' => 'string|nullable', 
			'CONSULTANT_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'CONSULTANT_SCREEN_DESC' => 'string|nullable' 
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

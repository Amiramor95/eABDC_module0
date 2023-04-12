<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ThirdPartyManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rule;

class ThirdPartyManageScreenController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ThirdPartyManageScreen::select('*')
            ->leftJoin('THIRDPARTY_MANAGE_MODULE AS MODULE', 'MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 'THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_MANAGE_MODULE_ID')
            ->leftJoin('THIRDPARTY_SUBMODULE AS SUBMODULE', 'SUBMODULE.THIRDPARTY_SUBMODULE_ID', '=', 'THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'THIRDPARTY_MANAGE_SCREEN.THIRDPARTY_SCREEN_PROCESS_ID')
            ->find($request->THIRDPARTY_MANAGE_SCREEN_ID);

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
            $data = DB::table('THIRDPARTY_SUBMODULE')
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
            $data = DB::table('THIRDPARTY_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.THIRDPARTY_MOD_NAME AS MOD_NAME')
            ->leftJoin('THIRDPARTY_MANAGE_MODULE AS MODULE', 'MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 'SCREEN.THIRDPARTY_MANAGE_MODULE_ID')
            ->leftJoin('THIRDPARTY_SUBMODULE AS SUBMODULE', 'SUBMODULE.THIRDPARTY_SUBMODULE_ID', '=', 'SCREEN.THIRDPARTY_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.THIRDPARTY_SCREEN_PROCESS_ID')
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

    public function getScreenByModule(Request $request)
    {
        try {
            $data = DB::table('THIRDPARTY_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.THIRDPARTY_MOD_NAME AS MOD_NAME')
            ->leftJoin('THIRDPARTY_MANAGE_MODULE AS MODULE', 'MODULE.THIRDPARTY_MANAGE_MODULE_ID', '=', 'SCREEN.THIRDPARTY_MANAGE_MODULE_ID')
            ->leftJoin('THIRDPARTY_SUBMODULE AS SUBMODULE', 'SUBMODULE.THIRDPARTY_SUBMODULE_ID', '=', 'SCREEN.THIRDPARTY_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.THIRDPARTY_SCREEN_PROCESS_ID');
            if($request->THIRDPARTY_MANAGE_MODULE_ID){
                $data->where('SCREEN.THIRDPARTY_MANAGE_MODULE_ID',$request->THIRDPARTY_MANAGE_MODULE_ID);
            }
            if($request->THIRDPARTY_SUBMODULE_ID){
                $data->where('SCREEN.THIRDPARTY_SUBMODULE_ID',$request->THIRDPARTY_SUBMODULE_ID);
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
    {
        //return $request->all();

        // Server side validation
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'THIRDPARTY_SCREEN_CODE' => 'required|unique:THIRDPARTY_MANAGE_SCREEN',
            'THIRDPARTY_MANAGE_SUBMODULE_ID' => 'required', 
			'THIRDPARTY_SCREEN_PROCESS_ID' => 'required', 
			'THIRDPARTY_SCREEN_NAME' => 'required',
            'THIRDPARTY_SCREEN_ROUTE' => 'required',
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $data = new ThirdPartyManageScreen;
            $data->THIRDPARTY_MANAGE_MODULE_ID = $request->THIRDPARTY_MODULE_ID;
            $data->THIRDPARTY_SUBMODULE_ID = $request->THIRDPARTY_MANAGE_SUBMODULE_ID;
            $data->THIRDPARTY_SCREEN_PROCESS_ID = $request->THIRDPARTY_SCREEN_PROCESS_ID;
            $data->THIRDPARTY_SCREEN_NAME = strtoupper($request->THIRDPARTY_SCREEN_NAME);
            $data->THIRDPARTY_SCREEN_ROUTE = ($request->THIRDPARTY_SCREEN_ROUTE);
            $data->THIRDPARTY_SCREEN_DESC = strtoupper($request->THIRDPARTY_SCREEN_DESC);
            $data->THIRDPARTY_SCREEN_CODE = strtoupper($request->THIRDPARTY_SCREEN_CODE);
            
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
                'message' => '',
                'errorCode' => 4104
            ],400);
        }
    }

    public function update(Request $request)
    {
        //return $request->all();

        // Server side validation
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'THIRDPARTY_SCREEN_CODE' => ['required',Rule::unique('THIRDPARTY_MANAGE_SCREEN')
            ->where(function ($query) use ($request) {
                return $query->where('THIRDPARTY_MANAGE_SCREEN_ID', '!=',  $request->THIRDPARTY_MANAGE_SCREEN_ID);
            })],
            'THIRDPARTY_MANAGE_SUBMODULE_ID' => 'required', 
			'THIRDPARTY_SCREEN_PROCESS_ID' => 'required', 
			'THIRDPARTY_SCREEN_NAME' => 'required',
            'THIRDPARTY_SCREEN_ROUTE' => 'required',
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $data = ThirdPartyManageScreen::find($request->THIRDPARTY_MANAGE_SCREEN_ID);
            $data->THIRDPARTY_MANAGE_MODULE_ID = $request->THIRDPARTY_MODULE_ID;
            $data->THIRDPARTY_SUBMODULE_ID = $request->THIRDPARTY_MANAGE_SUBMODULE_ID;
            $data->THIRDPARTY_SCREEN_PROCESS_ID = $request->THIRDPARTY_SCREEN_PROCESS_ID;
            $data->THIRDPARTY_SCREEN_NAME = strtoupper($request->THIRDPARTY_SCREEN_NAME);
            $data->THIRDPARTY_SCREEN_ROUTE = ($request->THIRDPARTY_SCREEN_ROUTE);
            $data->THIRDPARTY_SCREEN_DESC = strtoupper($request->THIRDPARTY_SCREEN_DESC);
            $data->THIRDPARTY_SCREEN_CODE = strtoupper($request->THIRDPARTY_SCREEN_CODE);
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
            $data = ThirdPartyManageScreen::find($request->THIRDPARTY_MANAGE_SCREEN_ID);
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

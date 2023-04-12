<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\DistributorManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rule;


class DistributorManageScreenController extends Controller
{
    public function get(Request $request)
    {
        try { //return 0;
            //$data = DistributorManageScreen::find($request->DISTRIBUTOR_MANAGE_SCREEN_ID);
            $data = DB::table('DISTRIBUTOR_MANAGE_SCREEN AS SCREEN')
                ->select('*')
                ->leftJoin('DISTRIBUTOR_MANAGE_MODULE AS MODULE', 'MODULE.DISTRIBUTOR_MANAGE_MODULE_ID', '=', 'SCREEN.DISTRIBUTOR_MODULE_ID')
                ->leftJoin('DISTRIBUTOR_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.DISTRIBUTOR_MANAGE_SUBMODULE_ID', '=', 'SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID')
                ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.DISTRIBUTOR_SCREEN_PROCESS_ID')
                ->where('DISTRIBUTOR_MANAGE_SCREEN_ID',$request->DISTRIBUTOR_MANAGE_SCREEN_ID)
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
    
    public function getSubmodule()
    {
        try {
            $data = DB::table('DISTRIBUTOR_MANAGE_SUBMODULE')
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

    public function getAll(Request $request)
    { 
        //return $request->all();
        try {
            $data = DB::table('DISTRIBUTOR_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.DISTRIBUTOR_MOD_NAME AS MOD_NAME')
            ->leftJoin('DISTRIBUTOR_MANAGE_MODULE AS MODULE', 'MODULE.DISTRIBUTOR_MANAGE_MODULE_ID', '=', 'SCREEN.DISTRIBUTOR_MODULE_ID')
            ->leftJoin('DISTRIBUTOR_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.DISTRIBUTOR_MANAGE_SUBMODULE_ID', '=', 'SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.DISTRIBUTOR_SCREEN_PROCESS_ID');
            if($request->DISTRIBUTOR_MANAGE_MODULE_ID){
                $data->where('SCREEN.DISTRIBUTOR_MODULE_ID',$request->DISTRIBUTOR_MANAGE_MODULE_ID);     
            }
            if($request->DISTRIBUTOR_MANAGE_SUBMODULE_ID){
                $data->where('SCREEN.DISTRIBUTOR_MANAGE_SUBMODULE_ID',$request->DISTRIBUTOR_MANAGE_SUBMODULE_ID);     
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
        // Server side validation
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'DISTRIBUTOR_SCREEN_CODE' => 'required|unique:DISTRIBUTOR_MANAGE_SCREEN',
        	'DISTRIBUTOR_MANAGE_SUBMODULE_ID' => 'required', 
			'DISTRIBUTOR_SCREEN_NAME' => 'required', 
			'DISTRIBUTOR_SCREEN_ROUTE' => 'required',
			'DISTRIBUTOR_SCREEN_PROCESS_ID' => 'required', 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $data = new DistributorManageScreen;
            $data->DISTRIBUTOR_MODULE_ID = $request->DISTRIBUTOR_MODULE_ID;
            $data->DISTRIBUTOR_MANAGE_SUBMODULE_ID = $request->DISTRIBUTOR_MANAGE_SUBMODULE_ID;
            $data->DISTRIBUTOR_SCREEN_PROCESS_ID = $request->DISTRIBUTOR_SCREEN_PROCESS_ID;
            $data->DISTRIBUTOR_SCREEN_NAME = strtoupper($request->DISTRIBUTOR_SCREEN_NAME);
            $data->DISTRIBUTOR_SCREEN_ROUTE = ($request->DISTRIBUTOR_SCREEN_ROUTE);
            $data->DISTRIBUTOR_SCREEN_DESC = strtoupper($request->DISTRIBUTOR_SCREEN_DESC);
            $data->DISTRIBUTOR_SCREEN_CODE = strtoupper($request->DISTRIBUTOR_SCREEN_CODE);
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'DISTRIBUTOR_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'DISTRIBUTOR_MODULE_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_NAME' => 'string|nullable', 
			'DISTRIBUTOR_SCREEN_ROUTE' => 'string|nullable', 
			'DISTRIBUTOR_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_DESC' => 'string|nullable' 
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
            'DISTRIBUTOR_SCREEN_CODE' => ['required',Rule::unique('DISTRIBUTOR_MANAGE_SCREEN')
            ->where(function ($query) use ($request) {
                return $query->where('DISTRIBUTOR_MANAGE_SCREEN_ID', '!=',  $request->DISTRIBUTOR_MANAGE_SCREEN_ID);
            })],
        	'DISTRIBUTOR_MANAGE_SUBMODULE_ID' => 'required', 
			'DISTRIBUTOR_SCREEN_NAME' => 'required', 
			'DISTRIBUTOR_SCREEN_ROUTE' => 'required',
			'DISTRIBUTOR_SCREEN_PROCESS_ID' => 'required', 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $data = DistributorManageScreen::find($request->DISTRIBUTOR_MANAGE_SCREEN_ID);
            $data->DISTRIBUTOR_MODULE_ID = $request->DISTRIBUTOR_MODULE_ID;
            $data->DISTRIBUTOR_MANAGE_SUBMODULE_ID = $request->DISTRIBUTOR_MANAGE_SUBMODULE_ID;
            $data->DISTRIBUTOR_SCREEN_PROCESS_ID = $request->DISTRIBUTOR_SCREEN_PROCESS_ID;
            $data->DISTRIBUTOR_SCREEN_NAME = strtoupper($request->DISTRIBUTOR_SCREEN_NAME);
            $data->DISTRIBUTOR_SCREEN_ROUTE = ($request->DISTRIBUTOR_SCREEN_ROUTE);
            $data->DISTRIBUTOR_SCREEN_DESC = strtoupper($request->DISTRIBUTOR_SCREEN_DESC);
            $data->DISTRIBUTOR_SCREEN_CODE = strtoupper($request->DISTRIBUTOR_SCREEN_CODE);
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
            $data = DistributorManageScreen::find($request->DISTRIBUTOR_MANAGE_SCREEN_ID);
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
			'DISTRIBUTOR_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'DISTRIBUTOR_MODULE_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_NAME' => 'string|nullable', 
			'DISTRIBUTOR_SCREEN_ROUTE' => 'string|nullable', 
			'DISTRIBUTOR_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'DISTRIBUTOR_SCREEN_DESC' => 'string|nullable' 
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

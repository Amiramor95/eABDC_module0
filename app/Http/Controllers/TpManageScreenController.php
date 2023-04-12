<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\TpManageScreen;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Validation\Rule;

class TpManageScreenController extends Controller
{
    public function get(Request $request)
    {
        try { 
            //RETURN $request->all();
            $data = TpManageScreen::select('*')
            ->leftJoin('TP_MANAGE_MODULE AS MODULE', 'MODULE.TP_MANAGE_MODULE_ID', '=', 'TP_MANAGE_SCREEN.TP_MANAGE_MODULE_ID')
            ->leftJoin('TP_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.TP_MANAGE_SUBMODULE_ID', '=', 'TP_MANAGE_SCREEN.TP_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'TP_MANAGE_SCREEN.TP_SCREEN_PROCESS_ID')
            ->find($request->TP_MANAGE_SCREEN_ID);

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
            $data = DB::table('TP_MANAGE_SUBMODULE')
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
            // $data = TpManageScreen::all();
            $data = DB::table('TP_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.TP_MOD_NAME AS MOD_NAME')
            ->leftJoin('TP_MANAGE_MODULE AS MODULE', 'MODULE.TP_MANAGE_MODULE_ID', '=', 'SCREEN.TP_MANAGE_MODULE_ID')
            ->leftJoin('TP_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.TP_MANAGE_SUBMODULE_ID', '=', 'SCREEN.TP_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.TP_SCREEN_PROCESS_ID')
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
            //return $request->all();
            $data = DB::table('TP_MANAGE_SCREEN AS SCREEN')
            ->select('*', 'MODULE.TP_MOD_NAME AS MOD_NAME')
            ->leftJoin('TP_MANAGE_MODULE AS MODULE', 'MODULE.TP_MANAGE_MODULE_ID', '=', 'SCREEN.TP_MANAGE_MODULE_ID')
            ->leftJoin('TP_MANAGE_SUBMODULE AS SUBMODULE', 'SUBMODULE.TP_MANAGE_SUBMODULE_ID', '=', 'SCREEN.TP_MANAGE_SUBMODULE_ID')
            ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'SCREEN.TP_SCREEN_PROCESS_ID');
            if($request->TP_MANAGE_MODULE_ID){
                $data->where('SCREEN.TP_MANAGE_MODULE_ID',$request->TP_MANAGE_MODULE_ID);
            }
            if($request->TP_MANAGE_SUBMODULE_ID){
                $data->where('SCREEN.TP_MANAGE_SUBMODULE_ID',$request->TP_MANAGE_SUBMODULE_ID);
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

        try {

            // Server side validation
            $messages = [
                'unique' => 'The code has already been taken',
                'required' => 'Required field can not be blank',
            ];
            $validator = Validator::make($request->all(), [
                'TP_SCREEN_CODE' => 'required|unique:TP_MANAGE_SCREEN',
                'TP_MANAGE_SUBMODULE_ID' => 'required', 
                'TP_MANAGE_MODULE_ID' => 'required', 
                'TP_SCREEN_NAME' => 'required', 
                'TP_SCREEN_ROUTE' => 'required', 
                'TP_SCREEN_PROCESS_ID' => 'integer|nullable', 
                'TP_SCREEN_DESC' => 'string|nullable' 
            ],$messages);

            if ($validator->fails()) {
                http_response_code(400);
                return response([
                    'message' => $validator->errors()->first(),
                    'errorCode' => 4106,
                ], 400);
            }

            $data = new TpManageScreen;
            $data->TP_MANAGE_MODULE_ID = $request->TP_MANAGE_MODULE_ID;
            $data->TP_MANAGE_SUBMODULE_ID = $request->TP_MANAGE_SUBMODULE_ID;
            $data->TP_SCREEN_PROCESS_ID = $request->TP_SCREEN_PROCESS_ID;
            $data->TP_SCREEN_NAME = strtoupper($request->TP_SCREEN_NAME);
            $data->TP_SCREEN_ROUTE = $request->TP_SCREEN_ROUTE;
            $data->TP_SCREEN_DESC = strtoupper($request->TP_SCREEN_DESC);
            $data->TP_SCREEN_CODE = strtoupper($request->TP_SCREEN_CODE);
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
			'TP_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'TP_MANAGE_MODULE_ID' => 'required|integer', 
			'TP_SCREEN_NAME' => 'string|nullable', 
			'TP_SCREEN_ROUTE' => 'string|nullable', 
			'TP_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'TP_SCREEN_DESC' => 'string|nullable' 
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
    
        try {

            // Server side validation
            $messages = [
                'unique' => 'The code has already been taken',
                'required' => 'Required field can not be blank',
            ];
            $validator = Validator::make($request->all(), [
                'TP_SCREEN_CODE' => ['required',Rule::unique('TP_MANAGE_SCREEN')
                ->where(function ($query) use ($request) {
                    return $query->where('TP_MANAGE_SCREEN_ID', '!=',  $request->TP_MANAGE_SCREEN_ID);
                })],
                'TP_MANAGE_SUBMODULE_ID' => 'required', 
                'TP_MANAGE_MODULE_ID' => 'required', 
                'TP_SCREEN_NAME' => 'required', 
                'TP_SCREEN_ROUTE' => 'required', 
                'TP_SCREEN_PROCESS_ID' => 'integer|nullable', 
                'TP_SCREEN_DESC' => 'string|nullable' 
            ],$messages);

            if ($validator->fails()) {
                http_response_code(400);
                return response([
                    'message' => $validator->errors()->first(),
                    'errorCode' => 4106,
                ], 400);
            }

            $data = TpManageScreen::find($request->TP_MANAGE_SCREEN_ID);
            $data->TP_MANAGE_MODULE_ID = $request->TP_MANAGE_MODULE_ID;
            $data->TP_MANAGE_SUBMODULE_ID = $request->TP_MANAGE_SUBMODULE_ID;
            $data->TP_SCREEN_PROCESS_ID = $request->TP_SCREEN_PROCESS_ID;
            $data->TP_SCREEN_NAME = strtoupper($request->TP_SCREEN_NAME);
            $data->TP_SCREEN_ROUTE = ($request->TP_SCREEN_ROUTE);
            $data->TP_SCREEN_DESC = strtoupper($request->TP_SCREEN_DESC);
            $data->TP_SCREEN_CODE = strtoupper($request->TP_SCREEN_CODE);
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
            $data = TpManageScreen::find($request->TP_MANAGE_SCREEN_ID);
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
			'TP_MANAGE_SUBMODULE_ID' => 'integer|nullable', 
			'TP_MANAGE_MODULE_ID' => 'required|integer', 
			'TP_SCREEN_NAME' => 'string|nullable', 
			'TP_SCREEN_ROUTE' => 'string|nullable', 
			'TP_SCREEN_PROCESS_ID' => 'integer|nullable', 
			'TP_SCREEN_DESC' => 'string|nullable' 
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

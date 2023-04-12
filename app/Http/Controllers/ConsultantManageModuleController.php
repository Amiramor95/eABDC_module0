<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ConsultantManageModule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class ConsultantManageModuleController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantManageModule::find($request->CONSULTANT_MANAGE_MODULE_ID);

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
            $data = ConsultantManageModule::all();

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
            'CONSULTANT_MOD_CODE' => 'required|unique:CONSULTANT_MANAGE_MODULE',
			'CONSULTANT_MOD_NAME' => 'required', 
			'CONSULTANT_MOD_SNAME' => 'required', 
			'CONSULTANT_MOD_INDEX' => 'required', 
			'CONSULTANT_MOD_ICON' => 'required' 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $data = new ConsultantManageModule;
            $data->CONSULTANT_MOD_CODE = strtoupper($request->CONSULTANT_MOD_CODE);
            $data->CONSULTANT_MOD_NAME = strtoupper($request->CONSULTANT_MOD_NAME);
            $data->CONSULTANT_MOD_SNAME = strtoupper($request->CONSULTANT_MOD_SNAME);
            $data->CONSULTANT_MOD_INDEX = $request->CONSULTANT_MOD_INDEX;
            $data->CONSULTANT_MOD_ICON = $request->CONSULTANT_MOD_ICON;
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
			'CONSULTANT_MOD_CODE' => 'required|string', 
			'CONSULTANT_MOD_NAME' => 'required|string', 
			'CONSULTANT_MOD_SNAME' => 'required|string', 
			'CONSULTANT_MOD_INDEX' => 'required|integer', 
			'CONSULTANT_MOD_ICON' => 'required|string' 
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
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'CONSULTANT_MOD_CODE' => ['required',Rule::unique('CONSULTANT_MANAGE_MODULE')
            ->where(function ($query) use ($request) {
                return $query->where('CONSULTANT_MANAGE_MODULE_ID', '!=',  $request->CONSULTANT_MANAGE_MODULE_ID);
            })],
			'CONSULTANT_MOD_NAME' => 'required', 
			'CONSULTANT_MOD_SNAME' => 'required', 
			'CONSULTANT_MOD_INDEX' => 'required', 
			'CONSULTANT_MOD_ICON' => 'required' 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
        
        try {
            $data = ConsultantManageModule::find($request->CONSULTANT_MANAGE_MODULE_ID);
            $data->CONSULTANT_MOD_CODE = strtoupper($request->CONSULTANT_MOD_CODE);
            $data->CONSULTANT_MOD_NAME = strtoupper($request->CONSULTANT_MOD_NAME);
            $data->CONSULTANT_MOD_SNAME = strtoupper($request->CONSULTANT_MOD_SNAME);
            $data->CONSULTANT_MOD_INDEX = $request->CONSULTANT_MOD_INDEX;
            $data->CONSULTANT_MOD_ICON = $request->CONSULTANT_MOD_ICON;
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
            $data = ConsultantManageModule::find($request->CONSULTANT_MANAGE_MODULE_ID);
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
			'CONSULTANT_MOD_CODE' => 'required|string', 
			'CONSULTANT_MOD_NAME' => 'required|string', 
			'CONSULTANT_MOD_SNAME' => 'required|string', 
			'CONSULTANT_MOD_INDEX' => 'required|integer', 
			'CONSULTANT_MOD_ICON' => 'required|string' 
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ThirdpartyManageModule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class ThirdpartyManageModuleController extends Controller
{
    public function get(Request $request)
    {
        //return $request->all();
        try {
            $data = ThirdpartyManageModule::find($request->THIRDPATY_MANAGE_MODULE);

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
            $data = ThirdpartyManageModule::all();

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
        
        try {

            // $validator = Validator::make($request->all(), [ 
            //     'THIRDPARTY_MOD_NAME' => 'required', 
            //     'THIRDPARTY_MOD_SNAME' => 'required', 
            //     'THIRDPARTY_MOD_INDEX' => 'required', 
            //     'THIRDPARTY_MOD_CODE' => 'required', 
            //     'THIRDPARTY_MOD_ICON' => 'required' 
            // ]);
    
            // if ($validator->fails()) {
            //     http_response_code(400);
            //     return response([
            //         'message' => 'Data validation error.',
            //         'errorCode' => 4106
            //     ],400);
            // }

            // Server side validation
            $messages = [
                'unique' => 'The code has already been taken',
                'required' => 'Required field can not be blank',
            ];
            $validator = Validator::make($request->all(), [
                'THIRDPARTY_MOD_CODE' => 'required|unique:THIRDPARTY_MANAGE_MODULE',
                'THIRDPARTY_MOD_NAME' => 'required', 
                'THIRDPARTY_MOD_SNAME' => 'required', 
                'THIRDPARTY_MOD_INDEX' => 'required', 
                'THIRDPARTY_MOD_ICON' => 'required'  
            ],$messages);

            if ($validator->fails()) {
                http_response_code(400);
                return response([
                    'message' => $validator->errors()->first(),
                    'errorCode' => 4106,
                ], 400);
            }

            $data = new ThirdpartyManageModule;
            $data->THIRDPARTY_MOD_CODE = strtoupper($request->THIRDPARTY_MOD_CODE);
            $data->THIRDPARTY_MOD_NAME = strtoupper($request->THIRDPARTY_MOD_NAME);
            $data->THIRDPARTY_MOD_SNAME = strtoupper($request->THIRDPARTY_MOD_SNAME);
            $data->THIRDPARTY_MOD_INDEX = $request->THIRDPARTY_MOD_INDEX;
            $data->THIRDPARTY_MOD_ICON = $request->THIRDPARTY_MOD_ICON;
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
			'THIRDPARTY_MOD_NAME' => 'string|nullable', 
			'THIRDPARTY_MOD_SNAME' => 'string|nullable', 
			'THIRDPARTY_MOD_INDEX' => 'integer|nullable', 
			'THIRDPARTY_MOD_CODE' => 'string|nullable', 
			'THIRDPARTY_MOD_ICON' => 'string|nullable' 
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
            // $validator = Validator::make($request->all(), [ 
            //     'THIRDPARTY_MOD_NAME' => 'required', 
            //     'THIRDPARTY_MOD_SNAME' => 'required', 
            //     'THIRDPARTY_MOD_INDEX' => 'required', 
            //     'THIRDPARTY_MOD_CODE' => 'required'
            // ]);
    
            // if ($validator->fails()) {
            //     http_response_code(400);
            //     return response([
            //         'message' => 'Data validation error.',
            //         'errorCode' => 4106
            //     ],400);
            // }

            // Server side validation
            $messages = [
                'unique' => 'The code has already been taken',
                'required' => 'Required field can not be blank',
            ];
            $validator = Validator::make($request->all(), [
                'THIRDPARTY_MOD_CODE' => ['required',Rule::unique('THIRDPARTY_MANAGE_MODULE')
                    ->where(function ($query) use ($request) {
                        return $query->where('THIRDPARTY_MANAGE_MODULE_ID', '!=',  $request->THIRDPARTY_MANAGE_MODULE_ID);
                    })],
                'THIRDPARTY_MOD_NAME' => 'required', 
                'THIRDPARTY_MOD_SNAME' => 'required', 
                'THIRDPARTY_MOD_INDEX' => 'required', 
                'THIRDPARTY_MOD_ICON' => 'required'  
            ],$messages);

            if ($validator->fails()) {
                http_response_code(400);
                return response([
                    'message' => $validator->errors()->first(),
                    'errorCode' => 4106,
                ], 400);
            }

            $data = ThirdpartyManageModule::find($request->THIRDPARTY_MANAGE_MODULE_ID);
            $data->THIRDPARTY_MOD_CODE = strtoupper($request->THIRDPARTY_MOD_CODE);
            $data->THIRDPARTY_MOD_NAME = strtoupper($request->THIRDPARTY_MOD_NAME);
            $data->THIRDPARTY_MOD_SNAME = strtoupper($request->THIRDPARTY_MOD_SNAME);
            $data->THIRDPARTY_MOD_INDEX = $request->THIRDPARTY_MOD_INDEX;
            $data->THIRDPARTY_MOD_ICON = $request->THIRDPARTY_MOD_ICON;
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
            $data = ThirdpartyManageModule::find($request->THIRDPARTY_MANAGE_MODULE_ID);
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
			'THIRDPARTY_MOD_NAME' => 'string|nullable', 
			'THIRDPARTY_MOD_SNAME' => 'string|nullable', 
			'THIRDPARTY_MOD_INDEX' => 'integer|nullable', 
			'THIRDPARTY_MOD_CODE' => 'string|nullable', 
			'THIRDPARTY_MOD_ICON' => 'string|nullable' 
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

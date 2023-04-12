<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\DistributorManageModule;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class DistributorManageModuleController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DistributorManageModule::find($request->DISTRIBUTOR_MANAGE_MODULE_ID);

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
            $data = DistributorManageModule::all();

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

        // $validator = Validator::make($request->all(), [ 
		// 	'DISTRIBUTOR_MOD_CODE' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_NAME' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_SNAME' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_INDEX' => 'required', 
		// 	'DISTRIBUTOR_MOD_ICON' => 'required|string' 
        // ]);

        // if ($validator->fails()) {
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Data validation error.',
        //         'errorCode' => 4106
        //     ],400);
        // }

        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'DISTRIBUTOR_MOD_CODE' => 'required|unique:DISTRIBUTOR_MANAGE_MODULE',
            'DISTRIBUTOR_MOD_NAME' => 'required', 
            'DISTRIBUTOR_MOD_SNAME' => 'required', 
            'DISTRIBUTOR_MOD_INDEX' => 'required', 
            'DISTRIBUTOR_MOD_ICON' => 'required' 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
        

        try {
            $data = new DistributorManageModule;
            $data->DISTRIBUTOR_MOD_CODE = strtoupper($request->DISTRIBUTOR_MOD_CODE);
            $data->DISTRIBUTOR_MOD_NAME = strtoupper($request->DISTRIBUTOR_MOD_NAME);
            $data->DISTRIBUTOR_MOD_SNAME = strtoupper($request->DISTRIBUTOR_MOD_SNAME);
            $data->DISTRIBUTOR_MOD_INDEX = $request->DISTRIBUTOR_MOD_INDEX;
            $data->DISTRIBUTOR_MOD_ICON = $request->DISTRIBUTOR_MOD_ICON;
            $data->save();
            
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully create.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be create.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'DISTRIBUTOR_MOD_CODE' => 'required|string', 
			'DISTRIBUTOR_MOD_NAME' => 'required|string', 
			'DISTRIBUTOR_MOD_SNAME' => 'required|string', 
			'DISTRIBUTOR_MOD_INDEX' => 'required|string', 
			'DISTRIBUTOR_MOD_ICON' => 'required|string' 
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
        // $validator = Validator::make($request->all(), [ 
		// 	'DISTRIBUTOR_MOD_CODE' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_NAME' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_SNAME' => 'required|string', 
		// 	'DISTRIBUTOR_MOD_INDEX' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Data validation error.',
        //         'errorCode' => 4106
        //     ],400);
        // }

        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'DISTRIBUTOR_MOD_CODE' => ['required',Rule::unique('DISTRIBUTOR_MANAGE_MODULE')
            ->where(function ($query) use ($request) {
                return $query->where('DISTRIBUTOR_MANAGE_MODULE_ID', '!=',  $request->DISTRIBUTOR_MANAGE_MODULE_ID);
            })],
            'DISTRIBUTOR_MOD_NAME' => 'required', 
            'DISTRIBUTOR_MOD_SNAME' => 'required', 
            'DISTRIBUTOR_MOD_INDEX' => 'required', 
            'DISTRIBUTOR_MOD_ICON' => 'required' 
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $data = DistributorManageModule::find($request->DISTRIBUTOR_MANAGE_MODULE_ID);
            $data->DISTRIBUTOR_MOD_CODE = strtoupper($request->DISTRIBUTOR_MOD_CODE);
            $data->DISTRIBUTOR_MOD_NAME = strtoupper($request->DISTRIBUTOR_MOD_NAME);
            $data->DISTRIBUTOR_MOD_SNAME = strtoupper($request->DISTRIBUTOR_MOD_SNAME);
            $data->DISTRIBUTOR_MOD_INDEX = $request->DISTRIBUTOR_MOD_INDEX;
            $data->DISTRIBUTOR_MOD_ICON = $request->DISTRIBUTOR_MOD_ICON;
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
            $data = DistributorManageModule::find($request->DISTRIBUTOR_MANAGE_MODULE_ID);
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
			'DISTRIBUTOR_MOD_CODE' => 'required|string', 
			'DISTRIBUTOR_MOD_NAME' => 'required|string', 
			'DISTRIBUTOR_MOD_SNAME' => 'required|string', 
			'DISTRIBUTOR_MOD_INDEX' => 'required|string', 
			'DISTRIBUTOR_MOD_ICON' => 'required|string' 
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

    // public function getModule(Request $request)
    // { 
    //     try {
    //         $data = DistributorManageModule::find($request->DISTRIBUTOR_MANAGE_MODULE_ID);

    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully retrieved.',
    //             'data' => $data
    //         ]);
    //     } catch (RequestException $r) {

    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to retrieve data.', 
    //             'errorCode' => 4103
    //         ],400);
    //     }
    // }


}

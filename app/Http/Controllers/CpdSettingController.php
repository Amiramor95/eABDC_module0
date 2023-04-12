<?php

namespace App\Http\Controllers;

use App\Models\CpdSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
 
class CpdSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = CpdSetting::find($request->CPD_SETTING_ID);
            $data->CPD_SETTING_NAME;
            $data->CPD_SETTING_MODE;
            $data->CPD_SETTING_INDEX;
            $data->CPD_SETTING_DESCRIPTION;
            $data->CPD_SETTING_TYPE;

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
        try {
            $data = CpdSetting::where('CPD_SETTING_TYPE',$request->CPD_SETTING_TYPE)->get();

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
                'CPD_SETTING_TYPE' => 'string|nullable',
                'CPD_SETTING_NAME' => 'string|nullable',
                'CPD_SETTING_MODE' => 'string|nullable',
                'CPD_SETTING_INDEX' => 'string|nullable',
                'CPD_SETTING_DESCRIPTION' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new CpdSetting;
            $data->CPD_SETTING_NAME= $request->CPD_SETTING_NAME;
            $data->CPD_SETTING_MODE= $request->CPD_SETTING_MODE;
            $data->CPD_SETTING_INDEX= $request->CPD_SETTING_INDEX;
            $data->CPD_SETTING_DESCRIPTION= $request->CPD_SETTING_DESCRIPTION;
            $data->CPD_SETTING_TYPE= $request->CPD_SETTING_TYPE;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
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
			'CPD_SETTING_TYPE' => 'string|nullable', 
			'CPD_SETTING_NAME' => 'string|nullable', 
			'CPD_SETTING_MODE' => 'string|nullable', 
			'CPD_SETTING_INDEX' => 'integer|nullable', 
			'CPD_SETTING_DESCRIPTION' => 'string|nullable' 
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
            'CPD_SETTING_TYPE' => 'string|nullable',
            'CPD_SETTING_NAME' => 'string|nullable',
            'CPD_SETTING_MODE' => 'string|nullable',
            'CPD_SETTING_INDEX' => 'string|nullable',
            'CPD_SETTING_DESCRIPTION' => 'string|nullable' //fresh
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data =CpdSetting::find($request->CPD_SETTING_ID);
            $data->CPD_SETTING_NAME= $request->CPD_SETTING_NAME;
            $data->CPD_SETTING_MODE= $request->CPD_SETTING_MODE;
            $data->CPD_SETTING_INDEX= $request->CPD_SETTING_INDEX;
            $data->CPD_SETTING_DESCRIPTION= $request->CPD_SETTING_DESCRIPTION;
            $data->save(); //nama column

            http_response_code(200);
            return response([
                'message' => ''
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
            $data = CpdSetting::find($request->CPD_SETTING_ID);
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
			'CPD_SETTING_TYPE' => 'string|nullable', 
			'CPD_SETTING_NAME' => 'string|nullable', 
			'CPD_SETTING_MODE' => 'string|nullable', 
			'CPD_SETTING_INDEX' => 'integer|nullable', 
			'CPD_SETTING_DESCRIPTION' => 'string|nullable' 
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

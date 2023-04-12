<?php

namespace App\Http\Controllers;

use App\Models\DeclarationSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Log;

class DeclarationSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DeclarationSetting::find($request->DeclarationSetting_ID);

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
            Log::info( "Set Type ===>" . $request);
            //dd( $request->query('DECLARATION_SET_PARAM'));
            $DECLARATION_SET_PARAM = $request->query('DECLARATION_SET_PARAM');
            $DECLARATION_SET_TYPE = $request->query('DECLARATION_SET_TYPE');
            $data = DeclarationSetting::where('DECLARATION_SET_PARAM',$DECLARATION_SET_PARAM)->where('DECLARATION_SET_TYPE',$DECLARATION_SET_TYPE)->get();

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
        $validator = Validator::make($request->all(), [ //fresh
            'DECLARATION_SET_TYPE' => 'required|string',
            'DECLARATION_SET_PARAM' => 'required|string',
            'DECLARATION_DESCRIPTION' => 'required|string',
            'DECLARATION_SET_INDEX' => 'required|integer',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //create function
            $create_by=$request->header('Uid');
            Log::info( "File Size Data ===>" . $request);
            //create function
            $data = new DeclarationSetting;
            $data->DECLARATION_SET_TYPE = $request->DECLARATION_SET_TYPE;
            $data->DECLARATION_SET_PARAM = $request->DECLARATION_SET_PARAM;
            $data->DECLARATION_DESCRIPTION = $request->DECLARATION_DESCRIPTION;
            $data->DECLARATION_SET_INDEX = $request->DECLARATION_SET_INDEX;
            $data->CREATE_BY = $create_by;
            $data->save();

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
        $validator = Validator::make($request->all(), [ //fresh
            'DECLARATION_SET_TYPE' => 'required|string',
            'DECLARATION_SET_PARAM' => 'required|string',
            'DECLARATION_DESCRIPTION' => 'required|string',
            'DECLARATION_SET_INDEX' => 'required|integer',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $create_by=$request->header('Uid');
            Log::info( "File Size Data1111111111 ===>" . $request);
            //create function
            $data = DeclarationSetting::where('DECLARATION_SETTING_ID',$request->DECLARATION_SETTING_ID);

            $data->where('DECLARATION_SETTING_ID',$request->DECLARATION_SETTING_ID)->update([
                'DECLARATION_SET_TYPE' => $request->DECLARATION_SET_TYPE,
                'DECLARATION_SET_PARAM' => $request->DECLARATION_SET_PARAM,
                'DECLARATION_DESCRIPTION' => $request->DECLARATION_DESCRIPTION,
                'DECLARATION_SET_INDEX' => $request->DECLARATION_SET_INDEX,
                'CREATE_BY' => $create_by,
                ]);

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
            $data = DeclarationSetting::find($request->DECLARATION_SETTING_ID);
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

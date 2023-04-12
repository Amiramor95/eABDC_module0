<?php

namespace App\Http\Controllers;

use App\Models\FileSizeSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Log;

class FileSizeSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = FileSizeSetting::orderBy('FILE_SIZE_SETTING_ID', 'desc')->first();

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
            $data = FileSizeSetting::all();

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
            'ADMIN_MODULE' => 'required|integer',
            'DISTRIBUTOR_MODULE' => 'required|integer',
            'CONSULTANT_MODULE' => 'required|integer',
            'CAS_MODULE' => 'required|integer',
            'CPD_MODULE' => 'required|integer',
            'FMS_MODULE' => 'required|integer',
            'FINANCE_MODULE' => 'required|integer',
            'AMSF_MODULE' => 'required|integer',
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
            Log::info( "File Size Data ===>" . $request);
            //create function
            $data = new FileSizeSetting;
            $data->ADMIN_MODULE = $request->ADMIN_MODULE;
            $data->DISTRIBUTOR_MODULE = $request->DISTRIBUTOR_MODULE;
            $data->CONSULTANT_MODULE = $request->CONSULTANT_MODULE;
            $data->CAS_MODULE = $request->CAS_MODULE;
            $data->CPD_MODULE = $request->CPD_MODULE;
            $data->FMS_MODULE = $request->FMS_MODULE;
            $data->FINANCE_MODULE = $request->FINANCE_MODULE;
            $data->AMSF_MODULE = $request->AMSF_MODULE;
            $data->CREATE_BY = $create_by;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Added.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be Added.',
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
            'ADMIN_MODULE' => 'required|integer',
            'DISTRIBUTOR_MODULE' => 'required|integer',
            'CONSULTANT_MODULE' => 'required|integer',
            'CAS_MODULE' => 'required|integer',
            'CPD_MODULE' => 'required|integer',
            'FMS_MODULE' => 'required|integer',
            'FINANCE_MODULE' => 'required|integer',
            'AMSF_MODULE' => 'required|integer',
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
            Log::info( "File Size Data ===>" . $request);
            //create function
            $data = FileSizeSetting::where('FILE_SIZE_SETTING_ID',$request->FILE_SIZE_SETTING_ID);

            $data->where('FILE_SIZE_SETTING_ID',$request->FILE_SIZE_SETTING_ID)->update([ 
                'ADMIN_MODULE' => $request->ADMIN_MODULE,
                'DISTRIBUTOR_MODULE' => $request->DISTRIBUTOR_MODULE,
                'CONSULTANT_MODULE' => $request->CONSULTANT_MODULE,
                'CAS_MODULE' => $request->CAS_MODULE,
                'CPD_MODULE' => $request->CPD_MODULE,
                'FMS_MODULE' => $request->FMS_MODULE,
                'FINANCE_MODULE' => $request->FINANCE_MODULE,
                'AMSF_MODULE' => $request->AMSF_MODULE,
                ]);

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ],400);
        }
    }

    public function delete($id)
    {
        try {
            $data = FileSizeSetting::find($id);
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

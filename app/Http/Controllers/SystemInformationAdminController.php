<?php

namespace App\Http\Controllers;

use App\Models\SystemInformationAdmin;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;

class SystemInformationAdminController extends Controller
{
    public function get(Request $request)
    {
        try {
            //Log::info("Request".$request->INFO_ID);
			$data = SystemInformationAdmin::orderBY('SYSTEM_INFORMATION_ID','asc')->get();

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
    public function getById(Request $request)
    {
        try {
            //Log::info("Request".$request->INFO_ID);
			//$data = SystemInformationAdmin::where('SYSTEM_INFORMATION_ID','=',$request->SYSTEM_INFORMATION_ID)->get();
            $data = SystemInformationAdmin::find($request->SYSTEM_INFORMATION_ID);
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'SYSTEM_MAIN_LABEL' => 'string|nullable',
        'SYSTEM_SUB_LABEL' => 'string|nullable',
        'PARAM_VALUE' => 'string|nullable',
        ]);

        if ($validator->fails()) {
        http_response_code(400);
        return response([
        'message' => 'Data validation error.',
        'errorCode' => 4106
        ],400);
        }

        try {
        $data = new SystemInformationAdmin;
        $data->SYSTEM_MAIN_LABEL = strtoupper($request->SYSTEM_MAIN_LABEL);
        $data->SYSTEM_SUB_LABEL = strtoupper($request->SYSTEM_SUB_LABEL);
        $data->PARAM_VALUE = $request->PARAM_VALUE;
        $data->save();

        //  foreach(json_decode($request->COUNTRY_LIST) as $element){
        //     $bulkupload = new SettingGeneral;
        //     $bulkupload->SET_PARAM = $element->SET_PARAM;
        //     $bulkupload->SET_TYPE = $element->SET_TYPE;
        //     $bulkupload->SET_VALUE = $element->SET_VALUE;
        //     $bulkupload->save();
        //    }

        http_response_code(200);
        return response([
        'message' => 'Data successfully updated.',
        'data' => $data
        // 'bulkUpload' => $bulkupload
        ]);

        } catch (RequestException $r) {

        http_response_code(400);
        return response([
        'message' => 'Data failed to be updated.',
        'errorCode' => 4100
        ],400);
        }

    }
    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        // 'DASHBOARD_LIST' => 'string|nullable',
        // 'DASHBOARD_DESCRIPTION' => 'string|nullable',
        // ]);

        // if ($validator->fails()) {
        // http_response_code(400);
        // return response([
        // 'message' => 'Data validation error.',
        // 'errorCode' => 4106
        // ],400);
        // }

        try {
        //create function
        $data = SystemInformationAdmin::find($request->SYSTEM_INFORMATION_ID);
        $data->SYSTEM_MAIN_LABEL = strtoupper($request->SYSTEM_MAIN_LABEL);
        $data->SYSTEM_SUB_LABEL = strtoupper($request->SYSTEM_SUB_LABEL);
        $data->PARAM_VALUE = $request->PARAM_VALUE;
        $data->save();

        //  foreach(json_decode($request->COUNTRY_LIST) as $element){
        //     $bulkupload = new SettingGeneral;
        //     $bulkupload->SET_PARAM = $element->SET_PARAM;
        //     $bulkupload->SET_TYPE = $element->SET_TYPE;
        //     $bulkupload->SET_VALUE = $element->SET_VALUE;
        //     $bulkupload->save();
        //    }

        http_response_code(200);
        return response([
        'message' => 'Data successfully updated.',
        'data' => $data
        // 'bulkUpload' => $bulkupload
        ]);

        } catch (RequestException $r) {

        http_response_code(400);
        return response([
        'message' => 'Data failed to be updated.',
        'errorCode' => 4100
        ],400);
        }

    }
    public function delete(Request $request)
    {
        try {
            $data = SystemInformationAdmin::find($request->SYSTEM_INFORMATION_ID);
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
}

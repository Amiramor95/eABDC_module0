<?php

namespace App\Http\Controllers;

use App\Models\DistributorSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;

class DistributorSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DistributorSetting::find($request->DISTRIBUTOR_SETTING_ID);

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
    public function getAppealRevoke(Request $request)
    {
        try {
            $data = DistributorSetting::where('DIST_SET_TYPE',$request->DIST_SET_TYPE)->orderBy('DISTRIBUTOR_SETTING_ID', 'desc')->first();

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
    public function getById(Request $request)
    {
        try {
            //$data = DistributorSetting::find($request->DISTRIBUTOR_SETTING_ID);

            $data = DB::table('admin_management.DISTRIBUTOR_SETTING AS DISTYPE')
            ->select(
                'DISTYPE.*',
                'DISSETTING.DIST_SET_PARAM AS DIST_SET_PARAM',
            )
            ->leftJoin('DISTRIBUTOR_SETTING AS DISSETTING', 'DISTYPE.DIST_SET_VALUE', '=', 'DISSETTING.DISTRIBUTOR_SETTING_ID')
            ->where('DISTYPE.DISTRIBUTOR_SETTING_ID', $request->DISTRIBUTOR_SETTING_ID)
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

    public function getAll(Request $request)
    {
        try {
            $data = DistributorSetting::where('DIST_SET_TYPE',$request->DIST_SET_TYPE)->get();

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
    public function getAllAppeal(Request $request)
    {
        try {
            $data = DistributorSetting::where('DIST_SET_TYPE',$request->DIST_SET_TYPE)->get();

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
    public function getAllReturnDuration(Request $request)
    {
        try {
            $data = DistributorSetting::where('DIST_SET_TYPE',$request->DIST_SET_TYPE)->orderBy('DISTRIBUTOR_SETTING_ID', 'desc')->first();

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
    public function getAllDeclaration(Request $request)
    {
        try {
            // $data = DistributorSetting::where('DIST_SET_TYPE',$request->DIST_SET_TYPE)->get();
                $data = DB::table('DISTRIBUTOR_SETTING AS DIST_SETTING')
                ->select('DIST_SETTING.DISTRIBUTOR_SETTING_ID', 'DIST_SETTING.DIST_SET_PARAM', 'DIST_SETTING.DIST_SET_DESCRIPTION', 'STATUS.DIST_SET_PARAM AS STATUS',
                'STATUS.DISTRIBUTOR_SETTING_ID AS ID' )
                ->leftJoin('DISTRIBUTOR_SETTING AS STATUS', 'STATUS.DISTRIBUTOR_SETTING_ID', '=', 'DIST_SETTING.DIST_SET_VALUE')
                ->where('DIST_SETTING.DIST_SET_TYPE',$request->DIST_SET_TYPE)
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

    public function create(Request $request)
    {
    
        try {
            $data = new DistributorSetting;
            $data->DIST_SET_TYPE = strtoupper($request->DIST_SET_TYPE);
            $data->DIST_SET_CODE = strtoupper($request->DIST_SET_CODE);
            $data->DIST_SET_PARAM = strtoupper($request->DIST_SET_PARAM);
            $data->DIST_SET_VALUE = strtoupper($request->DIST_SET_VALUE);
            $data->DIST_SET_INDEX = strtoupper($request->DIST_SET_INDEX);
            $data->DIST_SET_DESCRIPTION = strtoupper($request->DIST_SET_DESCRIPTION);
            $data->save();
            //create function
            

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be Creation.',
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
        //Log::info( "State Data ===>" . $request);

        try {
            $data = DistributorSetting::find($request->DISTRIBUTOR_SETTING_ID);
            $data->DIST_SET_CODE = strtoupper($request->DIST_SET_CODE);
            $data->DIST_SET_PARAM = strtoupper($request->DIST_SET_PARAM);
            $data->DIST_SET_VALUE = strtoupper($request->DIST_SET_VALUE);
            $data->DIST_SET_INDEX = strtoupper($request->DIST_SET_INDEX);
            $data->DIST_SET_DESCRIPTION = strtoupper($request->DIST_SET_DESRIPTION);
            $data->save();
            //dd($data);

            http_response_code(200);
            return response([
                'message' => 'Data Successfully Updated',
                'data' => $data
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
            $data = DistributorSetting::find($request->DISTRIBUTOR_SETTING_ID);
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

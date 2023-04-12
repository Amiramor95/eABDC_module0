<?php

namespace App\Http\Controllers;

use App\Models\DistributorType;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class DistributorTypeController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DistributorType::find($request->DISTRIBUTOR_TYPE_ID);

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
            ], 400);
        }
    }
    public function getDisTypeByID(Request $request)
    {
        try {
            $data = DB::table('admin_management.DISTRIBUTOR_TYPE AS DISTYPE')
                ->select(
                    'DISTYPE.*',
                    'DISSETTING.DIST_SET_PARAM AS DIST_SET_PARAM',
                    'DISSETTINGTYPE.DIST_SET_PARAM AS DIST_SET_PARAM1',
                    'CONTYPE.TYPE_SCHEME AS TYPE_SCHEME',
                )
                ->leftJoin('DISTRIBUTOR_SETTING AS DISSETTING', 'DISTYPE.MARKETING_APPROACH_ID', '=', 'DISSETTING.DISTRIBUTOR_SETTING_ID')
                ->leftJoin('DISTRIBUTOR_SETTING AS DISSETTINGTYPE', 'DISTYPE.TYPE_STRUCTURE_ID', '=', 'DISSETTINGTYPE.DISTRIBUTOR_SETTING_ID')
                ->leftJoin('CONSULTANT_TYPE AS CONTYPE', 'DISTYPE.SCHEME', '=', 'CONTYPE.CONSULTANT_TYPE_ID')
                ->where('DISTYPE.DISTRIBUTOR_TYPE_ID', $request->DISTRIBUTOR_TYPE_ID)
                ->first();
            // dd($data);

            //$data = DistributorType::find($request->DISTRIBUTOR_TYPE_ID);

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
            ], 400);
        }
    }

    public function getMarketing(Request $request)
    {
        try {
            $data = DB::table('DISTRIBUTOR_SETTING')
                ->select('DISTRIBUTOR_SETTING.DISTRIBUTOR_SETTING_ID', 'DISTRIBUTOR_SETTING.DIST_SET_PARAM')
                ->where('DISTRIBUTOR_SETTING.DIST_SET_TYPE', 'MARKETING_APPROACH')
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
            ], 400);
        }
    }

    public function getConsultantType(Request $request)
    {
        try {
            $data = DB::table('CONSULTANT_TYPE')
                ->select('CONSULTANT_TYPE.CONSULTANT_TYPE_ID', 'CONSULTANT_TYPE.TYPE_NAME',
                    'CONSULTANT_TYPE.TYPE_FULL_NAME','CONSULTANT_TYPE.TYPE_SCHEME')
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
            ], 400);
        }
    }

    public function getDistType(Request $request)
    {
        try {
            $data = DB::table('DISTRIBUTOR_TYPE')
                ->select('DISTRIBUTOR_TYPE_ID', 'DIST_TYPE_NAME')
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
            ], 400);
        }
    }
    public function getDummyType(Request $request)
    {
        try {
            $data = DB::table('DISTRIBUTOR_TYPE')
                ->select('DISTRIBUTOR_TYPE_ID', 'DIST_TYPE_NAME')
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
            ], 400);
        }
    }


    public function getAll(Request $request)
    {
        try {

            $data = DB::table('DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE')
                ->select(
                    'DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID',
                    'DISTRIBUTOR_TYPE.DIST_TYPE_VARIATION AS VARIATION',
                    'DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS TYPE_NAME',
                    'DISTRIBUTOR_TYPE.SCHEME',
                    'DIST_MARKETING.DIST_SET_PARAM AS MARKETING_APPROACH',
                    'DIST_MARKETING.DISTRIBUTOR_SETTING_ID',
                    'DIST_STRUCTURE.DIST_SET_PARAM AS TYPE_STRUCTURE',
                    'DIST_STRUCTURE.DISTRIBUTOR_SETTING_ID',
                    'CONSULTANT_TYPE.CONSULTANT_TYPE_ID',
                    'CONSULTANT_TYPE.TYPE_SCHEME AS CONS_NAME',
                    'DISTRIBUTOR_TYPE.ANNUALFEES_ID AS ANNUALFEE'
                )
                ->leftJoin('DISTRIBUTOR_SETTING AS DIST_MARKETING', 'DIST_MARKETING.DISTRIBUTOR_SETTING_ID', '=', 'DISTRIBUTOR_TYPE.MARKETING_APPROACH_ID')
                ->leftJoin('DISTRIBUTOR_SETTING AS DIST_STRUCTURE', 'DIST_STRUCTURE.DISTRIBUTOR_SETTING_ID', '=', 'DISTRIBUTOR_TYPE.TYPE_STRUCTURE_ID')
                ->leftJoin('CONSULTANT_TYPE AS CONSULTANT_TYPE', 'CONSULTANT_TYPE.CONSULTANT_TYPE_ID', '=', 'DISTRIBUTOR_TYPE.SCHEME')
                // ->where('DIST_MARKETING.DIST_SET_TYPE', 'MARKETING_APPROACH')
                // ->where('DIST_STRUCTURE.DIST_SET_TYPE', 'TYPE_STRUCTURE')
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
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [ //fresh
            'DIST_TYPE_NAME' => 'required',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }
        try {
            $data = new DistributorType;
            $data->DIST_TYPE_NAME = strtoupper($request->DIST_TYPE_NAME);
            $data->DIST_TYPE_VARIATION = $request->DIST_TYPE_VARIATION;
            $data->MARKETING_APPROACH_ID = $request->MARKETING_APPROACH_ID;
            $data->TYPE_STRUCTURE_ID = $request->TYPE_STRUCTURE_ID;
            $data->SCHEME = $request->SCHEME;
            $data->ANNUALFEES_ID = $request->ANNUALFEES_ID;
            $data->save();

            // $res = strtoupper($data);
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
            ], 400);
        }
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DIST_TYPE_NAME' => 'required|string',
            'DIST_TYPE_VARIATION' => 'required|string',
            'DIST_TYPE_MARKETING' => 'required|integer',
            'DIST_TYPE_STRUCTURE' => 'required|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
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
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [ //fresh
            'DIST_TYPE_NAME' => 'required',
        ]);



        try {
            $data = DistributorType::find($request->DISTRIBUTOR_TYPE_ID);

            $data->DIST_TYPE_NAME = strtoupper($request->DIST_TYPE_NAME);
            $data->DIST_TYPE_VARIATION = $request->DIST_TYPE_VARIATION;
            $data->MARKETING_APPROACH_ID = $request->MARKETING_APPROACH_ID;
            $data->TYPE_STRUCTURE_ID = $request->TYPE_STRUCTURE_ID;
            $data->SCHEME = $request->SCHEME; //nama column
            $data->ANNUALFEES_ID = $request->ANNUALFEES_ID;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data Successfully Updated'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = DistributorType::find($request->DISTRIBUTOR_TYPE_ID);
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
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DIST_TYPE_NAME' => 'required|string',
            'DIST_TYPE_VARIATION' => 'required|string',
            'DIST_TYPE_MARKETING' => 'required|integer',
            'DIST_TYPE_STRUCTURE' => 'required|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
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
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CpdRuleCalc;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class CpdRuleCalcController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = CPDRuleCalc::find($request->CPD_RULE_CALC_ID);

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
            $data = CPDRuleCalc::all();

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
            'CPD_RULE_TYPE' => 'required',
            'CPD_RULE_CONDITION' => 'required',
            'CPD_RULE_POINT' => 'required'
            //fresh
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
            $data = new CPDRuleCalc;
            $data->CPD_RULE_TYPE = strtoupper($request->CPD_RULE_TYPE);
            $data->CPD_RULE_CONDITION = $request->CPD_RULE_CONDITION;
            $data->CPD_RULE_POINT = $request->CPD_RULE_POINT;
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
            $validator = Validator::make($request->all(), [ 
			'CPD_RULE_TYPE' => 'string|nullable', 
			'CPD_RULE_CONDITION' => 'string|nullable', 
			'CPD_RULE_POINT' => 'integer|nullable' 
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
                'message' => 'Updated'
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
            'CPD_RULE_TYPE' => 'required',
            'CPD_RULE_CONDITION' => 'required',
            'CPD_RULE_POINT' => 'required'
            //fresh
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
            $data = CPDRuleCalc::find($request->CPD_RULE_CALC_ID);
            $data->CPD_RULE_TYPE = strtoupper($request->CPD_RULE_TYPE);
            $data->CPD_RULE_CONDITION = $request->CPD_RULE_CONDITION;
            $data->CPD_RULE_POINT = $request->CPD_RULE_POINT;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ],400);
        }
    }
    public function delete(Request $request)
    {
        try {
            $data = CPDRuleCalc::find($request->CPD_RULE_CALC_ID);
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

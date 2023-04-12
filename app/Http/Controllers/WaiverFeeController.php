<?php

namespace App\Http\Controllers;

use App\Models\WaiverFee;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class WaiverFeeController extends Controller
{
    public function get(Request $request)
    { 
       // return $request->all();
        try {
            //$data = WaiverFee::find($request->WAIVER_FEE_ID);

            $data = DB::table('WAIVER_FEE AS FEE')
            // ->select('FEE.WAIVER_FEE_ID', 'FEE.EXAM_FEE AS EXAM_FEE', 'FEE.ANNUAL_FEE AS ANNUAL_FEE', 'FEE.PROCESSING_FEE AS PROCESSING_FEE',
            // 'FEE.VARIATION_FEE AS VARIATION_FEE', 'FEE.AUTHORISATION_CARD_FEE AS AUTHORISATION_CARD_FEE', 'FEE.TOTAL_FEE AS TOTAL_FEE', 'FEE.TAX_FEE AS TAX_FEE',
            // 'FEE.TOTAL_AMOUNT_FEE AS TOTAL_AMOUNT_FEE', 'FEE.WAIVER_START_DATE AS WAIVER_START_DATE', 'FEE.WAIVER_END_DATE  AS WAIVER_END_DATE',
            //  'EXAM_TYPE.EXAM_TYPE_NAME AS EXAM_TYPE_NAME', 'CONS_TYPE.TYPE_NAME AS TYPE_NAME', 'WAIVER_TYPE.SET_PARAM AS WAIVER_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID',
            //  'FEE_TYPE.SET_PARAM AS FEE_TYPE')
             ->select('*')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'FEE.EXAM_TYPE_ID')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS WAIVER_TYPE', 'WAIVER_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_FEE_TYPE_ID')
            ->where('WAIVER_TYPE.SET_TYPE', '=', 'WAIVERTYPE')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->where('FEE.WAIVER_FEE_ID',$request->WAIVER_FEE_ID)->first();

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

    public function getExamType(Request $request)
    {
        try {
            $data = DB::table('CONSULTANT_EXAM_TYPE')
            ->select('*')
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
            ],400);
        }
    }
    public function getConsType(Request $request)
    {
        try {
            $data = DB::table('CONSULTANT_TYPE')
            ->select('*')
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
            ],400);
        }
    }
    public function getWaiverType(Request $request)
    {
        try {
            $data = DB::table('SETTING_GENERAL')
            ->select('SET_PARAM AS WAIVER_NAME', 'SETTING_GENERAL_ID AS WAIVER_ID')
            ->where('SET_TYPE', 'WAIVERTYPE')
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
            ],400);
        }
    }
    public function getFeeType(Request $request)
    {
        try {
            $data = DB::table('SETTING_GENERAL')
            ->select('SET_PARAM AS FEE_NAME', 'SETTING_GENERAL_ID AS FEE_ID')
            ->where('SET_TYPE', 'FEETYPE')
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
            ],400);
        }
    }
    public function getAll(Request $request)
    {
        try {
            // $data = WaiverFee::all();
            $data = DB::table('WAIVER_FEE AS FEE')
            ->select('FEE.WAIVER_FEE_ID', 'FEE.EXAM_FEE AS EXAM_FEE', 'FEE.ANNUAL_FEE AS ANNUAL_FEE', 'FEE.PROCESSING_FEE AS PROCESSING_FEE',
            'FEE.VARIATION_FEE AS VARIATION_FEE', 'FEE.AUTHORISATION_CARD_FEE AS AUTHORISATION_CARD_FEE', 'FEE.TOTAL_FEE AS TOTAL_FEE', 'FEE.TAX_FEE AS TAX_FEE',
            'FEE.TOTAL_AMOUNT_FEE AS TOTAL_AMOUNT_FEE', 'FEE.WAIVER_START_DATE AS WAIVER_START_DATE', 'FEE.WAIVER_END_DATE  AS WAIVER_END_DATE',
             'EXAM_TYPE.EXAM_TYPE_NAME AS EXAM_TYPE_NAME', 'CONS_TYPE.TYPE_NAME AS TYPE_NAME', 'WAIVER_TYPE.SET_PARAM AS WAIVER_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID',
             'FEE_TYPE.SET_PARAM AS FEE_TYPE')
            // ->select('*', '')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'FEE.EXAM_TYPE_ID')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS WAIVER_TYPE', 'WAIVER_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_FEE_TYPE_ID')
            ->where('WAIVER_TYPE.SET_TYPE', '=', 'WAIVERTYPE')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->get();
            
            foreach($data as $element){
                $element->WAIVER_START_DATE = date('d-M-Y', strtotime($element->WAIVER_START_DATE));
                $element->WAIVER_END_DATE = date('d-M-Y', strtotime($element->WAIVER_END_DATE));
            }

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
        // Server validation
        $validator = Validator::make($request->all(), [ 
			'WAIVER_TYPE_ID' => 'required', 
			'CONSULTANT_TYPE_ID' => 'required', 
			'EXAM_TYPE_ID' => 'required', 
			'EXAM_FEE' => 'required', 
			'ANNUAL_FEE' => 'required',
            'PROCESSING_FEE' => 'required',
            'VARIATION_FEE' => 'required',
            'AUTHORISATION_CARD_FEE' => 'required',
            'TOTAL_FEE' => 'required',
            'TAX_FEE' => 'required',
            'TOTAL_AMOUNT_FEE' => 'required',
            'WAIVER_START_DATE' => 'required|string',
            'WAIVER_END_DATE' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
                'error' => $validator->errors()->first()
            ],400);
        }
        
        try {

            $data = new WaiverFee;
            $data->WAIVER_FEE_TYPE_ID = $request->WAIVER_FEE_TYPE_ID;
            $data->WAIVER_TYPE_ID = $request->WAIVER_TYPE_ID;
            $data->CONSULTANT_TYPE_ID = $request->CONSULTANT_TYPE_ID;
            $data->EXAM_TYPE_ID = $request->EXAM_TYPE_ID;
            $data->EXAM_FEE = $request->EXAM_FEE;
            $data->ANNUAL_FEE = $request->ANNUAL_FEE;
            $data->PROCESSING_FEE = $request->PROCESSING_FEE;
            $data->VARIATION_FEE = $request->VARIATION_FEE;
            $data->AUTHORISATION_CARD_FEE = $request->AUTHORISATION_CARD_FEE;
            $data->TOTAL_FEE = $request->TOTAL_FEE;
            $data->TAX_FEE = $request->TAX_FEE;
            $data->TOTAL_AMOUNT_FEE = $request->TOTAL_AMOUNT_FEE;
            $data->WAIVER_START_DATE = $request->WAIVER_START_DATE;
            $data->WAIVER_END_DATE = $request->WAIVER_END_DATE;
            $data->save();

            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        

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
        // Server validation
        $validator = Validator::make($request->all(), [  
			'CONSULTANT_TYPE_ID' => 'required', 
			'EXAM_TYPE_ID' => 'required', 
			'EXAM_FEE' => 'required', 
			'ANNUAL_FEE' => 'required',
            'PROCESSING_FEE' => 'required',
            'VARIATION_FEE' => 'required',
            'AUTHORISATION_CARD_FEE' => 'required',
            'TOTAL_FEE' => 'required',
            'TAX_FEE' => 'required',
            'TOTAL_AMOUNT_FEE' => 'required',
            'WAIVER_START_DATE' => 'required|string',
            'WAIVER_END_DATE' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
                'error' => $validator->errors()->first()
            ],400);
        }
        
        try {
            $data = WaiverFee::find($request->WAIVER_FEE_ID);
            //$data->WAIVER_FEE_TYPE_ID = $request->WAIVER_FEE_TYPE_ID;
            $data->CONSULTANT_TYPE_ID = $request->CONSULTANT_TYPE_ID;
            $data->EXAM_TYPE_ID = $request->EXAM_TYPE_ID;
            $data->EXAM_FEE = $request->EXAM_FEE;
            $data->ANNUAL_FEE = $request->ANNUAL_FEE;
            $data->PROCESSING_FEE = $request->PROCESSING_FEE;
            $data->VARIATION_FEE = $request->VARIATION_FEE;
            $data->AUTHORISATION_CARD_FEE = $request->AUTHORISATION_CARD_FEE;
            $data->TOTAL_FEE = $request->TOTAL_FEE;
            $data->TAX_FEE = $request->TAX_FEE;
            $data->TOTAL_AMOUNT_FEE = $request->TOTAL_AMOUNT_FEE;
            $data->WAIVER_START_DATE = $request->WAIVER_START_DATE;
            $data->WAIVER_END_DATE = $request->WAIVER_END_DATE;
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
            $data = WaiverFee::find($request->WAIVER_FEE_ID);
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
        try {
            $start = $request->START_DATE;
            $end = $request->END_DATE;
            // $data = WaiverFee::all();
            $data = DB::table('WAIVER_FEE AS FEE')
            ->select('FEE.WAIVER_FEE_ID', 'FEE.EXAM_FEE AS EXAM_FEE', 'FEE.ANNUAL_FEE AS ANNUAL_FEE', 'FEE.PROCESSING_FEE AS PROCESSING_FEE',
            'FEE.VARIATION_FEE AS VARIATION_FEE', 'FEE.AUTHORISATION_CARD_FEE AS AUTHORISATION_CARD_FEE', 'FEE.TOTAL_FEE AS TOTAL_FEE', 'FEE.TAX_FEE AS TAX_FEE',
            'FEE.TOTAL_AMOUNT_FEE AS TOTAL_AMOUNT_FEE', 'FEE.WAIVER_START_DATE AS WAIVER_START_DATE', 'FEE.WAIVER_END_DATE  AS WAIVER_END_DATE',
             'EXAM_TYPE.EXAM_TYPE_NAME AS EXAM_TYPE_NAME', 'CONS_TYPE.TYPE_NAME AS TYPE_NAME', 'WAIVER_TYPE.SET_PARAM AS WAIVER_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID',
             'FEE_TYPE.SET_PARAM AS FEE_TYPE')
            // ->select('*', '')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'FEE.EXAM_TYPE_ID')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS WAIVER_TYPE', 'WAIVER_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'FEE.WAIVER_FEE_TYPE_ID')
            ->where('WAIVER_TYPE.SET_TYPE', '=', 'WAIVERTYPE')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->where('FEE.WAIVER_START_DATE','>=',$start)
            ->where('FEE.WAIVER_END_DATE','<=',$end)
            ->get();
            
            foreach($data as $element){
                $element->WAIVER_START_DATE = date('d-M-Y', strtotime($element->WAIVER_START_DATE));
                $element->WAIVER_END_DATE = date('d-M-Y', strtotime($element->WAIVER_END_DATE));
            }

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
}

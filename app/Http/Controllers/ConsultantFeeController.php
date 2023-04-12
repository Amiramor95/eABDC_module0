<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\ConsultantFee;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
class ConsultantFeeController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantFee::select('*')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'CONSULTANT_FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'CONSULTANT_FEE.EXAM_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'CONSULTANT_FEE.CONSULTANT_FEE_TYPE_ID')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->find($request->CONSULTANT_FEE_ID);

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
            // $data = ConsultantFee::all();
            $data = DB::table('CONSULTANT_FEE AS FEE')
            ->select('*')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'FEE.EXAM_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'FEE.CONSULTANT_FEE_TYPE_ID')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->orderBy('CONS_EFFECTIVE_DATE','desc')
            ->get();

            foreach($data as $element){
                $element->CONS_EFFECTIVE_DATE = date('d-M-Y', strtotime($element->CONS_EFFECTIVE_DATE));
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
        // Server validation
        $validator = Validator::make($request->all(), [  
			'CONSULTANT_FEE_TYPE_ID' => 'required', 
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
            'CONS_EFFECTIVE_DATE' => 'required',
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
            $data = new ConsultantFee;
            $data->CONSULTANT_FEE_TYPE_ID = $request->CONSULTANT_FEE_TYPE_ID;
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
            $data->CONS_EFFECTIVE_DATE = $request->CONS_EFFECTIVE_DATE;
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
        // Server validation
        $validator = Validator::make($request->all(), [  
			'CONSULTANT_FEE_TYPE_ID' => 'required', 
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
            'CONS_EFFECTIVE_DATE' => 'required',
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
            $data = ConsultantFee::find($request->CONSULTANT_FEE_ID);
            $data->CONSULTANT_FEE_TYPE_ID = $request->CONSULTANT_FEE_TYPE_ID;
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
            $data->CONS_EFFECTIVE_DATE = $request->CONS_EFFECTIVE_DATE;
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
            $data = ConsultantFee::find($request->CONSULTANT_FEE_ID);
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
            // $data = ConsultantFee::all();
            $start = $request->START_DATE;
            $end = $request->END_DATE;
            Log::info("start_date=".$start);
            $data = DB::table('CONSULTANT_FEE AS FEE')
            ->select('*')
            ->leftJoin('CONSULTANT_TYPE AS CONS_TYPE', 'CONS_TYPE.CONSULTANT_TYPE_ID', '=', 'FEE.CONSULTANT_TYPE_ID')
            ->leftJoin('CONSULTANT_EXAM_TYPE AS EXAM_TYPE', 'EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'FEE.EXAM_TYPE_ID')
            ->leftJoin('SETTING_GENERAL AS FEE_TYPE', 'FEE_TYPE.SETTING_GENERAL_ID', '=', 'FEE.CONSULTANT_FEE_TYPE_ID')
            ->where('FEE_TYPE.SET_TYPE', '=', 'FEETYPE')
            ->whereBetween('CONS_EFFECTIVE_DATE', [$start, $end])
            ->orderBy('CONS_EFFECTIVE_DATE','desc')
            ->get();
            //Log::info(print_r($data));

            foreach($data as $element){
                $element->CONS_EFFECTIVE_DATE = date('d-M-Y', strtotime($element->CONS_EFFECTIVE_DATE));
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

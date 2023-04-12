<?php

namespace App\Http\Controllers;

use App\Models\CpdRenewalCalc;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CpdRenewalCalcController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = CpdRenewalCalc::find($request->CPD_RENEWAL_CALC_ID); 

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
            $data = CpdRenewalCalc::orderBy('EFFECTIVE_YEAR','desc')->orderBy('RENEWAL_MONTH','desc')->get();

            foreach($data as $item){
                if ($item->RENEWAL_MONTH !=null){  
                }else 
                {$item->RENEWAL_MONTH = $item->RENEWAL_MONTH ?? '-' ; }
                if ($item->RENEWAL_CALC){
    
                }else {$item->RENEWAL_CALC = $item->RENEWAL_CALC ?? '-' ;}
                if ($item->RENEWAL_REQUIREMENT){
    
                }else {$item->RENEWAL_REQUIREMENT = $item->RENEWAL_REQUIREMENT ?? '-' ;}
    
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

        $year = date('Y', strtotime($request->EFFECTIVE_DATE));
       // Log::info("YEAR =". $year);
            $validator = Validator::make($request->all(), [
			'RENEWAL_MONTH' => 'required',
			'RENEWAL_CALC' => 'required',
			'RENEWAL_REQUIREMENT' => 'required',
            'EFFECTIVE_DATE' => 'required'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data_exist = CpdRenewalCalc::where('RENEWAL_MONTH',$request->RENEWAL_MONTH)->where('EFFECTIVE_YEAR',$year)->first();
            if(!$data_exist){
                $data = new CpdRenewalCalc;
                $data->RENEWAL_MONTH = $request->RENEWAL_MONTH;
                $data->RENEWAL_CALC = $request->RENEWAL_CALC;
                $data->EFFECTIVE_DATE = $request->EFFECTIVE_DATE;
                $data->EFFECTIVE_YEAR = $year;
                $data->save();//create function

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.'
                ]);
          }
          else{
            http_response_code(400);
            return response([
                'message' => 'Data Already Exists in this month',
                'errorCode' => 4100
            ],400);
          }

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
			'RENEWAL_MONTH' => 'required',
			'RENEWAL_CALC' => 'required',
			'RENEWAL_REQUIREMENT' => 'required'
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
			'RENEWAL_MONTH' => 'required',
			'RENEWAL_CALC' => 'required',
			'RENEWAL_REQUIREMENT' => 'required'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $year = date('Y', strtotime($request->EFFECTIVE_DATE));
            //update function
            $data =CpdRenewalCalc::find($request->CPD_RENEWAL_CALC_ID);
            $data->RENEWAL_MONTH = $request->RENEWAL_MONTH;
            $data->RENEWAL_CALC = $request->RENEWAL_CALC;
            $data->RENEWAL_REQUIREMENT = $request->RENEWAL_REQUIREMENT;
            $data->EFFECTIVE_DATE = $request->EFFECTIVE_DATE;
            $data->EFFECTIVE_YEAR = $year;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated',
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated', 
                'errorCode' => 4102
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = CpdRenewalCalc::find($request->CPD_RENEWAL_CALC_ID);
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
			'RENEWAL_MONTH' => 'required|integer', 
			'RENEWAL_CALC' => 'required|integer', 
			'RENEWAL_REQUIREMENT' => 'required|integer' 
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

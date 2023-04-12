<?php

namespace App\Http\Controllers;

use App\Models\AnnualFeesDate;
use App\Models\RnaVerificationPeriod;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class AnnualFeesDateController extends Controller
{
    public function getbyId(Request $request)
    { 
        try {
            $data = AnnualFeesDate::find($request->ANNUAL_FEES_DATE_ID);

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
            $data = AnnualFeesDate::orderBy('ANNUAL_FEES_DATE_ID', 'desc')->first();

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
    public function getAllListDate(Request $request)
    {
        try {
    
            $data = DB::table('ANNUAL_FEES_DATE AS ANNUAL')
            ->select('ANNUAL.ANNUAL_FEES_DATE_ID','ANNUAL.ASSESSMENT_YEAR','ANNUAL.ASSESSMENT_START_DATE', 'ANNUAL.ASSESSMENT_END_DATE', 'ANNUAL.SUBMISSION_START_DATE',
            'ANNUAL.SUBMISSION_END_DATE', 'RNA.RNA_START_DATE', 'RNA.RNA_END_DATE')
            ->leftJoin('RNA_VERIFICATION_PERIOD AS RNA', 'RNA.RNA_VERIFICATION_PERIOD_ID', '=', 'ANNUAL.RNA_VERIFICATION_PERIOD_ID')
            ->get();
            
            foreach($data as $element){
                $element->ASSESSMENT_START_DATE = date('d-M-Y', strtotime($element->ASSESSMENT_START_DATE));
                $element->ASSESSMENT_END_DATE = date('d-M-Y', strtotime($element->ASSESSMENT_END_DATE));
                $element->SUBMISSION_START_DATE = date('d-M-Y', strtotime($element->SUBMISSION_START_DATE));
                $element->SUBMISSION_END_DATE = date('d-M-Y', strtotime($element->SUBMISSION_END_DATE));
                $element->RNA_END_DATE = date('d-M-Y', strtotime($element->RNA_END_DATE));
                $element->RNA_START_DATE = date('d-M-Y', strtotime($element->RNA_START_DATE));                
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
    
        try {
            $rules =[];
            if ($request->input('ASSESSMENT_YEAR') == "Invalid date") {
                $rules['ASSESSMENT_YEAR'] = 'required|string';
            }
            if ($request->input('ASSESSMENT_START_DATE') == "Invalid date") {
                $rules['ASSESSMENT_START_DATE'] = 'required|string';
            }
            if ($request->input('ASSESSMENT_END_DATE') == "Invalid date") {
                $rules['ASSESSMENT_END_DATE'] = 'required|string';
            }
            if ($request->input('SUBMISSION_START_DATE') == "Invalid date") {
                $rules['SUBMISSION_START_DATE'] = 'required|string';
            }
            if ($request->input('SUBMISSION_END_DATE') == "Invalid date") {
                $rules['SUBMISSION_END_DATE'] = 'required|string';
            }
            //$validator = Validator::make($request->all(), $rules);
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Data validation error.',
                    'errorCode' => 4106
                ],400);
            }

            $dataRna = new RnaVerificationPeriod;
            $dataRna->RNA_START_DATE = $request->RNA_START_DATE;
            $dataRna->RNA_END_DATE = $request->RNA_END_DATE;
            $dataRna->save();

            $data = new AnnualFeesDate;
            $data->RNA_VERIFICATION_PERIOD_ID = $dataRna->RNA_VERIFICATION_PERIOD_ID;
            $data->ASSESSMENT_YEAR = $request->ASSESSMENT_YEAR;
            $data->ASSESSMENT_START_DATE = $request->ASSESSMENT_START_DATE;
            $data->ASSESSMENT_END_DATE = $request->ASSESSMENT_END_DATE;
            $data->SUBMISSION_START_DATE = $request->SUBMISSION_START_DATE;
            $data->SUBMISSION_END_DATE = $request->SUBMISSION_END_DATE;
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
        //return $request->all(); 
        $validator = Validator::make($request->all(), [ 
            'ASSESSMENT_YEAR' => 'string|required', 
            'ASSESSMENT_START_DATE' => 'string|required',
            'SUBMISSION_START_DATE' => 'string|required',
            'SUBMISSION_END_DATE' => 'string|required', 
            'ASSESSMENT_END_DATE' => 'string|required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $dataRna = RnaVerificationPeriod::find($request->RNA_VERIFICATION_PERIOD_ID);
            $dataRna->RNA_START_DATE = $request->RNA_START_DATE;
            $dataRna->RNA_END_DATE = $request->RNA_END_DATE;
            $dataRna->save();

            $data = AnnualFeesDate::find($request->ANNUAL_FEES_DATE_ID);
            $data->RNA_VERIFICATION_PERIOD_ID = $dataRna->RNA_VERIFICATION_PERIOD_ID;
            $data->ASSESSMENT_YEAR = $request->ASSESSMENT_YEAR;
            $data->ASSESSMENT_START_DATE = $request->ASSESSMENT_START_DATE;
            $data->ASSESSMENT_END_DATE = $request->ASSESSMENT_END_DATE;
            $data->SUBMISSION_START_DATE = $request->SUBMISSION_START_DATE;
            $data->SUBMISSION_END_DATE = $request->SUBMISSION_END_DATE;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
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
            $data = AnnualFeesDate::find($id);
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

<?php

namespace App\Http\Controllers;

use App\Models\CpdCutOffDate;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
 
class CpdCutOffDateController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = CpdCutOffDate::orderBy('CPD_CUT_OFF_DATE_ID', 'desc')->first();
            // foreach($data as $item){
            //     $item->CPD_CUT_OFF_START_DATE = date('d-M-Y', strtotime($item->CPD_CUT_OFF_START_DATE));
            //     $item->CPD_CUT_OFF_END_DATE = date('d-M-Y', strtotime($item->CPD_CUT_OFF_END_DATE));
            // }
            
            $data->CPD_CUT_OFF_START_DATE_DISPLAY = date('d-m-Y', strtotime($data->CPD_CUT_OFF_START_DATE));
            $data->CPD_CUT_OFF_END_DATE_DISPLAY = date('d-m-Y', strtotime($data->CPD_CUT_OFF_END_DATE));
            

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
            $data = CpdCutOffDate::find($request->CPD_CUT_OFF_DATE_ID)->first();
            // foreach($data as $item){
            //     $item->CPD_CUT_OFF_START_DATE =  $item->CPD_CUT_OFF_START_DATE ?? '-';
            //     $item->CPD_CUT_OFF_END_DATE =  $item->CPD_CUT_OFF_END_DATE ?? '-';
            //     // $item->CALENDAR_DATE_START = date('d-m-Y', strtotime($item->CALENDAR_DATE_START));
            //     // $item->CALENDAR_DATE_START = date('d-m-Y', strtotime($item->CALENDAR_DATE_START));
            //     // $item->NRIC = substr($item->NRIC, 0, 6).'-'.substr($item->NRIC, 6, 2).'-'.substr($item->NRIC, 8, 4);
            // }

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
            'CPD_CUT_OFF_DATE' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            // $data = CpdCutOffDate::first();
            if($request->CPD_CUT_OFF_DATE_ID == 0){
                $data = new CpdCutOffDate;
            }else{
                $data = CpdCutOffDate::find($request->CPD_CUT_OFF_DATE_ID);
            }
            // $data = new CpdCutOffDate;
            $data->CPD_CUT_OFF_DATE = $request->CPD_CUT_OFF_DATE;
            $data->save();//create function

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
			'CPD_CUT_OFF_START_DATE' => 'string|nullable', 
			'CPD_CUT_OFF_END_DATE' => 'string|nullable' 
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
            // 'CPD_CUT_OFF_DATE_ID' => 'required|integer',
            'CPD_CUT_OFF_START_DATE' => 'nullable|string',
            'CPD_CUT_OFF_END_DATE' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = CpdCutOffDate::where($request->CPD_CUT_OFF_DATE_ID)->first();
            $data->CPD_CUT_OFF_START_DATE = $request->CPD_CUT_OFF_START_DATE;
            $data->CPD_CUT_OFF_END_DATE = $request->CPD_CUT_OFF_END_DATE;
            $data->save(); //nama column
    

            http_response_code(200);
            return response([
                'message' => 'Sucessfully updated'
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
            $data = CpdCutOffDate::find($request->CPD_CUT_OFF_DATE_ID);
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
			'CPD_CUT_OFF_START_DATE' => 'string|nullable', 
			'CPD_CUT_OFF_END_DATE' => 'string|nullable' 
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

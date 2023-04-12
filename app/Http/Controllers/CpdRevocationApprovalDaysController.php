<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use LaravelKeycloakAdmin\Facades\KeycloakAdmin;
use Validator;
use App\Models\CpdRevocationApprovalDays;
use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Session;
use DB;

class CpdRevocationApprovalDaysController extends Controller
{
    public function get()
    {
        try {
            $data = CpdRevocationApprovalDays::orderBy('REVOCATION_ID','desc')->first();
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
            'REVOCATION_APPROVAL_DAYS' => 'nullable|string',
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
           // if($request->CPD_CUT_OFF_DATE_ID == 0){
                $data = new CpdRevocationApprovalDays;
            // }else{
            //     $data = CpdCutOffDate::find($request->CPD_CUT_OFF_DATE_ID);
            // }
            // $data = new CpdCutOffDate;
            $data->REVOCATION_APPROVAL_DAYS = $request->REVOCATION_APPROVAL_DAYS;
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
}

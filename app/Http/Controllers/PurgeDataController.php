<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurgeDataPeriod;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class PurgeDataController extends Controller
{
    //

    public function get(Request $request)
    {
        try {
            $data = PurgeDataPeriod::first();

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
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'PURGE_DATA' => 'required'
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

        try {
                $data =  PurgeDataPeriod::first();
                if($request->PURGE_DATA_TYPE == 1){
                    $data->DIST_DURATION = $request->PURGE_DATA;
                }elseif($request->PURGE_DATA_TYPE == 2){
                    $data->CONST_DURATION = $request->PURGE_DATA;
                }elseif($request->PURGE_DATA_TYPE == 3){
                    $data->THIRD_DURATION = $request->PURGE_DATA;
                }elseif($request->PURGE_DATA_TYPE == 4){
                    $data->TP_DURATION = $request->PURGE_DATA;
                }
                $data->save();
                //Save function

                http_response_code(200);
                return response([
                    'message' => 'Data successfully saved.'
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

<?php

namespace App\Http\Controllers;

use App\Models\SmsTac;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\SMS;
use Validator;
use Config;
use Illuminate\Support\Facades\Log;

class SmsTacController extends Controller
{
    public function getTAC(Request $request)
    {
        try {
            $tac = mt_rand(100000, 999999);

            $end_time = \Carbon\Carbon::now()->addMinutes(60)->timestamp;

            $request->tac = strval($tac);

            $sms = new SMS();

            $result = $sms->sendTAC($request);
            // if($result->data == false)
            // {
            //     http_response_code(400);
            //     return response([
            //         'message' => 'SMS failed to be send.',
            //         'errorCode' => 4104
            //     ],400);
            // }

            $smsTac = new SmsTac;
            $smsTac->SMS_TAC_NUMBER	= $tac;
            $smsTac->SMS_TAC_RECIPIENT = $request->phoneNo;
            $smsTac->SMS_TAC_END_TIME = $end_time;
            $smsTac->save();

            $response = $result->data;

            http_response_code(200);
            return response([
                'message' => 'SMS successfully send.',
                'tac' => $tac
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'SMS failed to be send.',
                'errorCode' => 4104
            ], 400);
        }
    }
    public function getTACFORGOT(Request $request)
    {
        try {
           // $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

           // $tac = substr(str_shuffle(str_repeat($pool, 5)), 0, 8);
           $tac = mt_rand(100000, 999999);

            $end_time = \Carbon\Carbon::now()->addMinutes(60)->timestamp;

            $request->tac = strval($tac);

            $sms = new SMS();

            $result = $sms->sendTAC($request);
            // if($result->data == false)
            // {
            //     http_response_code(400);
            //     return response([
            //         'message' => 'SMS failed to be send.',
            //         'errorCode' => 4104
            //     ],400);
            // }

            $smsTac = new SmsTac;
            $smsTac->SMS_TAC_NUMBER	= $tac;
            $smsTac->SMS_TAC_RECIPIENT = $request->phoneNo;
            $smsTac->SMS_TAC_END_TIME = $end_time;
            $smsTac->save();

            $response = $result->data;

            http_response_code(200);
            return response([
                'message' => 'SMS successfully send.',
                'tac' => $tac
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'SMS failed to be send.',
                'errorCode' => 4104
            ], 400);
        }
    }

    public function verifyTAC(Request $request)
    {
        try {
           // Log::info("Req =". $request);
            $time_now = \Carbon\Carbon::now()->timestamp;

            $data = SmsTac::where('SMS_TAC_NUMBER', $request->SMS_TAC_NUMBER)
            ->where('SMS_TAC_RECIPIENT', $request->SMS_TAC_RECIPIENT)
            ->first();

            if ($data != null) {
                if ($time_now > $data->SMS_TAC_END_TIME) {
                    http_response_code(400);
                    return response([
                        'message' => 'TAC code is expired.',
                    ], 400);
                } else {
                    http_response_code(200);
                    return response([
                        'message' => 'TAC code successfully verified.',
                        'data' => $data->SMS_TAC_NUMBER
                    ], 200);
                }
            } else {
                http_response_code(400);
                return response([
                    'message' => 'TAC code not found.',
                    'errorCode' => 4109
                ], 400);
            }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Your TAC code is failed to verify',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function get(Request $request)
    {
        try {
            $data = SmsTac::find($request->SMS_TAC_ID);

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

    public function getAll()
    {
        try {
            $data = SmsTac::all();

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
        $validator = Validator::make($request->all(), [
            'SMS_TAC_NUMBER' => 'required|integer',
            'SMS_TAC_RECIPIENT' => 'required|string',
            'SMS_TAC_END_TIME' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
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
            'SMS_TAC_NUMBER' => 'required|integer',
            'SMS_TAC_RECIPIENT' => 'required|string',
            'SMS_TAC_END_TIME' => 'required|string'
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'SMS_TAC_NUMBER' => 'required|integer',
            'SMS_TAC_RECIPIENT' => 'required|string',
            'SMS_TAC_END_TIME' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            $data = SmsTac::where('id', $id)->first();
            $data->TEST = $request->TEST; //nama column
            $data->save();

            http_response_code(200);
            return response([
                'message' => ''
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $data = SmsTac::find($id);
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
            'SMS_TAC_NUMBER' => 'required|integer',
            'SMS_TAC_RECIPIENT' => 'required|string',
            'SMS_TAC_END_TIME' => 'required|string'
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

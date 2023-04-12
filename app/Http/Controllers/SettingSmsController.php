<?php

namespace App\Http\Controllers;

use App\Models\SettingSms;
use App\Models\SettingHttp;
use App\Models\SmsLog;
use App\Helpers\SMS;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;

class SettingSmsController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = SettingSms::orderBy('SETTING_SMS_ID', 'desc')->first();

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
            $data = SettingSms::first();

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
			'SMS_HTTP_URL' => 'string',
			'SMS_HTTP_PARAM' => 'string',
			'SMS_REQ_HEADER' => 'string',
			//'SMS_RES_SUCCESS' => 'string',
			//'SMS_RES_FAILURE' => 'string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }


        try {

            $data = new SettingSms;
            $data->SMS_HTTP_URL = $request->SMS_HTTP_URL;
            $data->SMS_HTTP_PARAM = $request->SMS_HTTP_PARAM;
            $data->SMS_REQ_HEADER = $request->SMS_REQ_HEADER;
            $data->SMS_RES_SUCCESS = $request->SMS_RES_SUCCESS;
            $data->SMS_RES_FAILURE = $request->SMS_RES_FAILURE;
            $data->save();
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
            ],400);
        }

    }
    public function testConnection(Request $request){

        try{
            //  Get HTTP Setting
            $dataHttp = SettingHttp::orderBy('SETTING_HTTP_ID', 'desc')->first();
            $httpUserName = $dataHttp->USER_NAME;
            $httpApiKey = $dataHttp->API_KEY;
            $httpApiSecret = $dataHttp->API_SECRET;
            $httpAllowIp = $dataHttp->ALLOW_IP;
            $httpDlrUrl= $dataHttp->DLR_URL;

            //  Get SMS Setting
            $smsHttpUrl=$request->SMS_HTTP_URL;
            $smsHttpParam=$request->SMS_HTTP_PARAM;
            $smsHttpHeader=$request->SMS_REQ_HEADER;
            $smsHttpResSus=$request->SMS_RES_SUCCESS;
            $smsHttpResFa=$request->SMS_RES_FAILURE;
            $paramstr= explode("&", $smsHttpParam);
            $paramto=explode("=", $paramstr[0]);
            $paramtext=explode("=", $paramstr[1]);
          //  Log::info("sssssssssssssssssssssss");

            $response = Curl::to($smsHttpUrl)
            ->withData(['mocean-api-key' => $httpApiKey, 'mocean-api-secret' => $httpApiSecret, 'mocean-from' => $httpUserName,
            'mocean-to' => $paramto[1], 'mocean-text' => $paramtext[1]])
            ->returnResponseObject()
            ->post();

            $xmlResp = simplexml_load_string( $response->content );
            $msgId = "NO_ID";
            if($xmlResp){
                $msgId = $xmlResp->messages->message->msgid;
            }
            $log = new SmsLog();
            $log->SMS_MESSAGE_ID = $msgId;
            $log->SMS_RECIPIENT = $paramto[1];
            $log->MESSAGE = $paramtext[1];
            $log->SMS_STATUS = 1;
            $log->save();
            return $response;
        }
        catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }
    }

    public function test(Request $request)
    {
        try {

            $sms = new SMS();

            $result = $sms->testSend($request);

            if($result->expired)
            {
                return redirect('expired');
            }

            $response = $result->data;

            $responseArray = json_decode($response,true);

            // echo $responseArray['messages'][0]['msgid'];
            // $msgId = $responseArray['messages'][0]['msgid'];
            // {
            //     "messages":[
            //       {
            //         "status": 0,
            //         "receiver": "60173788399",
            //         "msgid": "cust20013050311050614001"
            //       }
            //     ]
            //   }

            $log = new SmsLog();
            $log->SMS_MESSAGE_ID = 1;
            $log->SMS_RECIPIENT = $request->phoneNo;
            $log->SMS_STATUS = 0;
            $log->save();


            http_response_code(200);
            return response([
                'message' => 'SMS successfully tested.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'SMS failed to be tested.',
                'errorCode' => 4104
            ],400);
        }
    }

    public function getLog()
    {
        try {
            $sms = new SMS();

            $result = $sms->getLog();

            if($result->expired)
            {
                return redirect('expired');
            }

            $response = $result->data;


            http_response_code(200);
            return response([
                'message' => $response
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'SMS log failed to be retrieved.',
                'errorCode' => 4104
            ],400);
        }
    }


    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'SMS_HTTP_URL' => 'required|string',
			'SMS_HTTP_PARAM' => 'required|string',
			'SMS_REQ_HEADER' => 'required|string',
			//'SMS_RES_SUCCESS' => 'string',
			//'SMS_RES_FAILURE' => 'string'
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
            $data = SettingSms::where('SETTING_SMS_ID',$request->SETTING_SMS_ID);
            $data->where('SETTING_SMS_ID',$request->SETTING_SMS_ID)->update([
                'SMS_HTTP_URL' => $request->SMS_HTTP_URL,
                'SMS_HTTP_PARAM' => $request->SMS_HTTP_PARAM,
                'SMS_REQ_HEADER' => $request->SMS_REQ_HEADER,
                'SMS_RES_SUCCESS' => $request->SMS_RES_SUCCESS,
                'SMS_RES_FAILURE' => $request->SMS_RES_FAILURE,
                ]);

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104
            ],400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [ 
			'SMS_HTTP_URL' => 'string',
			'SMS_HTTP_PARAM' => 'string',
			'SMS_REQ_HEADER' => 'string',
			'SMS_RES_SUCCESS' => 'string',
			'SMS_RES_FAILURE' => 'string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = SettingSms::where('id',$id)->first();
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
            ],400);
        }
    }

    public function delete($id)
    {
        try {
            $data = SettingSms::find($id);
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
			'SMS_HTTP_URL' => 'string', 
			'SMS_HTTP_PARAM' => 'string', 
			'SMS_REQ_HEADER' => 'string', 
			'SMS_RES_SUCCESS' => 'string', 
			'SMS_RES_FAILURE' => 'string' 
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

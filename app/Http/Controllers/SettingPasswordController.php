<?php

namespace App\Http\Controllers;

use App\Models\SettingPassword;
use App\Models\SecurityQuestion;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;

class SettingPasswordController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = SettingPassword::orderBy('SETTING_PASSWORD_ID','desc')->first();

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
            $data = SettingPassword::all();

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
    public function getSecurityQuestion()
    {
        try {
            $data = SecurityQuestion::all();

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
			'SECURITY_QUESTION' => 'nullable|integer', 
			'MAX_LENGTH' => 'nullable|integer', 
			'UPPERCASE_LOWERCASE' => 'nullable|boolean', 
			'ALPHANUMERIC' => 'nullable|boolean', 
			'SPECIAL_CHARACTERS' => 'nullable|boolean' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

            $data = new SettingPassword;
            $data->MIN_LENGTH = $request->MIN_LENGTH;
            $data->MAX_LENGTH = $request->MAX_LENGTH;
            $data->UPPERCASE_LOWERCASE = $request->UPPERCASE_LOWERCASE;
            $data->ALPHANUMERIC = $request->ALPHANUMERIC;
            $data->SPECIAL_CHARACTERS = $request->SPECIAL_CHARACTERS;
            $data->save();

        try {
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
    public function createsecurityquestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'SECURITY_QUESTION' => 'required|string',
        ]);
       // Log::info( "request ===>" . $request->all());

        if ($validator->fails()) {
        http_response_code(400);
        return response([
        'message' => 'Data validation error.',
        'errorCode' => 4106
        ],400);
        }

        $data = new SecurityQuestion;
        $data->SECURITY_QUESTION = $request->SECURITY_QUESTION;
        $data->save();

        try {
        //create function

        http_response_code(200);
        return response([
        'message' => 'Data successfully Inserted.'
        ]);

        } catch (RequestException $r) {

        http_response_code(400);
        return response([
        'message' => 'Data failed to be created.',
        'errorCode' => 4100
        ],400);
        }

    }
    public function getsecurityquestionbyid(Request $request)
    {
        try {
			$data = SecurityQuestion::find($request->SECURITY_ID);

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
    public function updatesecurityquestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SECURITY_QUESTION' => 'required|string',
            ]);
           // Log::info( "request ===>" . $request->all());
            if ($validator->fails()) {
            http_response_code(400);
            return response([
            'message' => 'Data validation error.',
            'errorCode' => 4106
            ],400);
            }

        try {
            $data = SecurityQuestion::find($request->SECURITY_ID);
            $data->SECURITY_QUESTION = $request->SECURITY_QUESTION;
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
    public function  deletesecurityquestion(Request $request)
    {
        try {
            $data = SecurityQuestion::find($request->SECURITY_ID);
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

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'MIN_LENGTH' => 'required|integer', 
			'MAX_LENGTH' => 'required|integer', 
			'UPPERCASE_LOWERCASE' => 'required|integer', 
			'ALPHANUMERIC' => 'required|integer', 
			'SPECIAL_CHARACTERS' => 'required|integer' 
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
            'MIN_LENGTH' => 'nullable|integer',
            'MAX_LENGTH' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => $validator->errors()//4106
            ],400);
        }

        try {
            $data = SettingPassword::find($request->SETTING_PASSWORD_ID);
            $data->MIN_LENGTH = $request->MIN_LENGTH;
            $data->MAX_LENGTH = $request->MAX_LENGTH;
            $data->UPPERCASE_LOWERCASE = $request->UPPERCASE_LOWERCASE;
            $data->ALPHANUMERIC = $request->ALPHANUMERIC;
            $data->SPECIAL_CHARACTERS = $request->SPECIAL_CHARACTERS;
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
    public function delete($id)
    {
        try {
            $data = SettingPassword::find($id);
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
			'MIN_LENGTH' => 'required|integer', 
			'MAX_LENGTH' => 'required|integer', 
			'UPPERCASE_LOWERCASE' => 'required|integer', 
			'ALPHANUMERIC' => 'required|integer', 
			'SPECIAL_CHARACTERS' => 'required|integer' 
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

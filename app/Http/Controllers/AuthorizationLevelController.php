<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationLevel;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class AuthorizationLevelController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = AuthorizationLevel::find($request->AUTHORIZATION_LEVEL_ID); 

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
            $data = AuthorizationLevel::all();

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
        // Server side data validation
        $validator = Validator::make($request->all(), [
            'AUTHORIZATION_LEVEL_NAME' => 'required', //Cuti raya cina
        ]);
        if ($validator->fails()) {
            http_response_code(400);
            return response(['message' => 'Data validation error'],400);
        }


        try {
             $data = new AuthorizationLevel;
             $data->AUTHORIZATION_LEVEL_NAME = $request->AUTHORIZATION_LEVEL_NAME;
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
    public function update(Request $request)
    {
        // Server side data validation
        $validator = Validator::make($request->all(), [
            'AUTHORIZATION_LEVEL_NAME' => 'required', //Cuti raya cina
        ]);
        if ($validator->fails()) {
            http_response_code(400);
            return response(['message' => 'Data validation error'],400);
        }

        try {
            $data = AuthorizationLevel::find($request->AUTHORIZATION_LEVEL_ID);
            $data->AUTHORIZATION_LEVEL_NAME = $request->AUTHORIZATION_LEVEL_NAME;
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

    public function delete(Request $request)
    {
        try {
            $data = AuthorizationLevel::find($request->AUTHORIZATION_LEVEL_ID);
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
 
}

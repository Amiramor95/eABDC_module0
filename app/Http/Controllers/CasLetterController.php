<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\CasLetter;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CasLetterController extends Controller
{
    public function get(Request $request)
    {
        try {
			$letter = CasLetter::find($request->CAS_LETTER_ID); 
        // dd($data);
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $letter
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
            $data = CasLetter::select('CAS_LETTER.*','USER.USER_NAME')
                ->leftJoin('USER','USER.USER_ID','CAS_LETTER.CREATE_BY')
                ->get();

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
        //return $request->all();
        $validator = Validator::make($request->all(), [ 
			'CAS_LETTER_TITTLE' => 'required|string', 
			'CAS_LETTER_DESC' => 'required|string' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
             $data = new CasLetter;
             $data->CAS_LETTER_TITTLE = strtoupper($request->CAS_LETTER_TITTLE);
             $data->CAS_LETTER_DESC = strtoupper($request->CAS_LETTER_DESC);
             $data->CREATE_BY = $request->CREATE_BY;
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
        $validator = Validator::make($request->all(), [ 
			'CAS_LETTER_TITTLE' => 'required|string', 
			'CAS_LETTER_DESC' => 'required|string' 
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
			'CAS_LETTER_TITTLE' => 'required|string', 
			'CAS_LETTER_DESC' => 'required|string' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = CasLetter::find($request->CAS_LETTER_ID);
            $data->CAS_LETTER_TITTLE = strtoupper($request->CAS_LETTER_TITTLE);
            $data->CAS_LETTER_DESC = strtoupper($request->CAS_LETTER_DESC);
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
            $data = CasLetter::find($request->CAS_LETTER_ID);
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
			'CAS_LETTER_TITTLE' => 'required|string', 
			'CAS_LETTER_DESC' => 'required|string' 
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

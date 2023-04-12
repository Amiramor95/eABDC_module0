<?php

namespace App\Http\Controllers;

use App\Models\ManageEventDocument;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use File;
use App\Models\CircularEventDocument;

class ManageEventDocumentController extends Controller
{
    public function get(Request $request)
    {
        try { 
            //return $request->all();
			$data = ManageEventDocument::where('MANAGE_EVENT_ID', 117)
            ->get(); 
            //$files = CircularEventDocument::where('CIRCULAR_EVENT_ID',66)->get();
            // $data = ManageEventDocument::find($request->MANAGE_EVENT_DOCUMENT_ID)
            // ->where('MANAGE_EVENT_ID', $request->MANAGE_EVENT_ID)
            // ->get();
            foreach($data as $element){
                $element->DOCUMENT_BLOB = base64_encode($element->DOCUMENT_BLOB);
            };

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
            $data = ManageEventDocument::all();

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
			'MANAGE_EVENT_ID' => 'required|integer', 
			'DOCUMENT_FILETYPE' => 'required|integer', 
			'DOCUMENT_FILENAME' => 'required|string', 
			'DOCUMENT_FILEPATH' => 'required|string', 
			'DOCUMENT_FILEDESCRIPTION' => 'required|string', 
			'CREATE_BY' => 'required|integer', 
			'CREATE_TIMESTAMP' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
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
            ],400);
        }

    }

    public function manage(Request $request)
    {
$validator = Validator::make($request->all(), [ 
			'MANAGE_EVENT_ID' => 'required|integer', 
			'DOCUMENT_FILETYPE' => 'required|integer', 
			'DOCUMENT_FILENAME' => 'required|string', 
			'DOCUMENT_FILEPATH' => 'required|string', 
			'DOCUMENT_FILEDESCRIPTION' => 'required|string', 
			'CREATE_BY' => 'required|integer', 
			'CREATE_TIMESTAMP' => 'required|integer' 
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

    public function update(Request $request, $id)
    {
$validator = Validator::make($request->all(), [ 
			'MANAGE_EVENT_ID' => 'required|integer', 
			'DOCUMENT_FILETYPE' => 'required|integer', 
			'DOCUMENT_FILENAME' => 'required|string', 
			'DOCUMENT_FILEPATH' => 'required|string', 
			'DOCUMENT_FILEDESCRIPTION' => 'required|string', 
			'CREATE_BY' => 'required|integer', 
			'CREATE_TIMESTAMP' => 'required|integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = ManageEventDocument::where('id',$id)->first();
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
            $data = ManageEventDocument::find($id);
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
			'MANAGE_EVENT_ID' => 'required|integer', 
			'DOCUMENT_FILETYPE' => 'required|integer', 
			'DOCUMENT_FILENAME' => 'required|string', 
			'DOCUMENT_FILEPATH' => 'required|string', 
			'DOCUMENT_FILEDESCRIPTION' => 'required|string', 
			'CREATE_BY' => 'required|integer', 
			'CREATE_TIMESTAMP' => 'required|integer' 
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

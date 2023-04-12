<?php

namespace App\Http\Controllers;

use App\Models\CpdModulePoint;
use DB;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class CpdModulePointController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = CpdModulePoint::find($request->CPD_HOURS_ID);

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
         $data = CpdModulePoint::where('CPD_PROGRAM_TYPE',$request->CPD_PROGRAM_TYPE)->get();


            foreach($data as $item){
                if ($item->CPD_PRORGAM_NAME !=null){  
                }else 
                {$item->CPD_PRORGAM_NAME = $item->CPD_PROGRAM_NAME ?? '-' ; }
                if ($item->CPD_MIN){
    
                }else {$item->CPD_MIN = $item->CPD_MIN ?? '-' ;}
                if ($item->CPD_MAX){
    
                }else {$item->CPD_MAX = $item->CPD_MAX ?? '-' ;}

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

    public function getAllfiveModule(Request $request)
    {
        try {

        $data = DB::table('CPD_HOURS')
        ->select('CPD_HOURS.CPD_HOURS_ID', 'CPD_HOURS.CPD_PROGRAM_NAME AS PROGRAM_NAME', 'CPD_HOURS.CPD_MIN AS CPD_MIN', 'CPD_HOURS.CPD_MAX AS CPD_MAX')
        ->where('CPD_HOURS.CPD_PROGRAM_TYPE', '=', '506')
        ->get();

        foreach($data as $item){
            if ($item->PROGRAM_NAME!=null){  
            }else 
            {$item->PROGRAM_NAME = $item->PROGRAM_NAME ?? '-' ; }

            if ($item->CPD_MIN){

            }else {$item->CPD_MIN = $item->CPD_MIN ?? '-' ;}
            
            if ($item->CPD_MAX){

            }else {$item->CPD_MAX = $item->CPD_MAX ?? '-' ;}

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
        $validator = Validator::make($request->all(), [ 
			'CPD_PROGRAM_TYPE' => 'required', 
			'CPD_PROGRAM_NAME' => 'required', 
			'CPD_MIN' => 'required', 
			'CPD_MAX' => 'required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new CpdModulePoint;
             $data->CPD_PROGRAM_TYPE = $request->CPD_PROGRAM_TYPE;
             $data->CPD_PROGRAM_NAME = strtoupper($request->CPD_PROGRAM_NAME);
             $data->CPD_MIN = $request->CPD_MIN;
             $data->CPD_MAX = $request->CPD_MAX;
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

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'CPD_PROGRAM_TYPE' => 'integer|nullable',
			'CPD_PROGRAM_NAME' => 'required|string',
			'CPD_MIN' => 'required|integer',
			'CPD_MAX' => 'required|integer'
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
			'CPD_PROGRAM_TYPE' => 'integer|nullable', 
			'CPD_PROGRAM_NAME' => 'string|nullable', 
			'CPD_MIN' => 'string|nullable', 
			'CPD_MAX' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = CpdModulePoint::find($request->CPD_HOURS_ID);
            $data->CPD_HOURS_ID = $request->CPD_HOURS_ID;
            $data->CPD_PROGRAM_NAME = strtoupper($request->CPD_PROGRAM_NAME);
            $data->CPD_MIN = $request->CPD_MIN;
            $data->CPD_MAX = $request->CPD_MAX;
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
            $data = CpdModulePoint::find($request->CPD_HOURS_ID);
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
            'CPD_PROGRAM_TYPE' => 'integer|nullable', 
			'CPD_PROGRAM_NAME' => 'required|string', 
			'CPD_MIN' => 'required|integer', 
			'CPD_MAX' => 'required|integer' 
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

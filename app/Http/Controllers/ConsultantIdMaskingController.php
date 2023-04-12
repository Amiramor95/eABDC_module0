<?php

namespace App\Http\Controllers;

use App\Models\ConsultantIdMasking;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;
use DB;

class ConsultantIdMaskingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantIdMasking::find($request->CONSULTANT_MASKING_ID);

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
            //Log::info( "SETTYPE ===>" . $request->MASKING_TYPE);
            $data = ConsultantIdMasking::orderBy('CONSULTANT_MASKING_ID','desc')->get();

           // var_dump();

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
    public function getLatest(Request $request)
    {
        try {
           
            $query = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')->max('DISTRIBUTOR_ID');
            
              $data = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')
              ->select('DISTRIBUTOR.DIST_RUN_NO AS DIST_RUN_NO')
              ->where('DISTRIBUTOR.DISTRIBUTOR_ID','=',$query)
              ->first();
            //  Log::info(print_r($data));
            //  ConsultantIdMasking::orderBy('DISTRIBUTOR_MASKING_ID', 'DESC')->first();

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
           // 'PREFIX' => 'required|integer',
            'RUN_NO' => 'required|integer',
           // 'CURRENT_RUN_NO' => 'required|integer'
            ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $create_by=$request->header('Uid');
            //create function
            $idmasking = ConsultantIdMasking::where('RUN_NO', $request->RUN_NO)->first();
            if(!$idmasking)
            {
                $update=DB::table('admin_management.CONSULTANT_ID_MASKING_SETTING as CONSULTANT_ID_MASKING_SETTING')->update(['CONSULTANT_ID_MASKING_SETTING.STATUS' => 'INACTIVE']);

                $data = new ConsultantIdMasking;
                $data->PREFIX = $request->PREFIX;
                $data->RUN_NO = $request->RUN_NO;
                $data->CURRENT_RUN_NO = $request->RUN_NO;//$request->CURRENT_RUN_NO;
               // $data->MASKING_TYPE = $request->MASKING_TYPE;
                $data->DESCRIPTION = $request->DESCRIPTION;
                $data->STATUS = 'ACTIVE';
                $data->CREATE_BY = $create_by;
                $data->save();

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.'
                ]);
             }
             else{
                http_response_code(300);
                return response([
                    'message' => 'Data Already Exist!!'
                ]);
             }

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
        $validator = Validator::make($request->all(), [ //fresh
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
           // 'PREFIX' => 'required|integer',
            'RUN_NO' => 'required|integer',
            //'CURRENT_RUN_NO' => 'required|integer'
            ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }
        try {
            $create_by=$request->header('Uid');
            $data = ConsultantIdMasking::find($request->CONSULTANT_MASKING_ID);
            $data->PREFIX = $request->PREFIX;
            $data->RUN_NO = $request->RUN_NO;
            $data->CURRENT_RUN_NO = $request->RUN_NO;
            $data->DESCRIPTION = $request->DESCRIPTION;
            $data->CREATE_BY = $create_by;
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
            $data = ConsultantIdMasking::find($request->CONSULTANT_MASKING_ID);
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
        $validator = Validator::make($request->all(), [ //fresh
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

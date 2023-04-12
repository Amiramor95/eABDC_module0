<?php

namespace App\Http\Controllers;

use App\Models\ConsultantExaminationType;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class ConsultantExaminationTypeController extends Controller
{
    public function get(Request $request)
    {
        try {
            // $data = ConsultantExaminationType::find($request->CONSULTANT_EXAM_TYPE_ID);

            $data = DB::table('admin_management.CONSULTANT_EXAM_TYPE AS CONSULTANT_EXAM_TYPE')
                ->select(
                    'CONSULTANT_EXAM_TYPE.*',
                    'CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME',
            )
                ->leftJoin('admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE', 'CONSULTANT_TYPE.CONSULTANT_TYPE_ID', '=', 'CONSULTANT_EXAM_TYPE.CONSULTANT_TYPE_ID')
                ->where('CONSULTANT_EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', $request->CONSULTANT_EXAM_TYPE_ID)
                ->first();

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
           // $data = ConsultantExaminationType::all();

            $data = DB::table('admin_management.CONSULTANT_EXAM_TYPE AS CONSULTANT_EXAM_TYPE')
            ->select(
                'CONSULTANT_EXAM_TYPE.*',
                'CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME',
            )
            ->leftJoin('admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE', 'CONSULTANT_TYPE.CONSULTANT_TYPE_ID', '=', 'CONSULTANT_EXAM_TYPE.CONSULTANT_TYPE_ID')
           // ->where('DISTYPE.DISTRIBUTOR_SETTING_ID', $request->DISTRIBUTOR_SETTING_ID)
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
        $validator = Validator::make($request->all(), [
            'EXAM_TYPE_NAME' => 'required',
        ]);

        try {
            $data = new ConsultantExaminationType;
            $data->EXAM_TYPE_NAME = strtoupper($request->EXAM_TYPE_NAME);
            $data->EXAM_TYPE_DESC = strtoupper($request->EXAM_TYPE_DESC);
            $data->CONSULTANT_TYPE_ID = $request->CONSULTANT_TYPE_ID;
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


        try {
            $data = ConsultantExaminationType::find($request->CONSULTANT_EXAM_TYPE_ID);
            $data->EXAM_TYPE_NAME = strtoupper($request->EXAM_TYPE_NAME);
            $data->EXAM_TYPE_DESC = strtoupper($request->EXAM_TYPE_DESC);
            $data->CONSULTANT_TYPE_ID = $request->CONSULTANT_TYPE_ID;
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
            $data = ConsultantExaminationType::find($request->CONSULTANT_EXAM_TYPE_ID);
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

    public function getByConsultantId(Request $request)
    {
        try {
            $data = DB::table('admin_management.CONSULTANT_EXAM_TYPE AS CONSULTANT_EXAM_TYPE')
                ->select(
                    'CONSULTANT_EXAM_TYPE.*',
            )
                ->leftJoin('admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE', 'CONSULTANT_TYPE.CONSULTANT_TYPE_ID', '=', 'CONSULTANT_EXAM_TYPE.CONSULTANT_TYPE_ID')
                ->where('CONSULTANT_EXAM_TYPE.CONSULTANT_TYPE_ID', $request->CONSULTANT_TYPE_ID)
                ->get();

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

}

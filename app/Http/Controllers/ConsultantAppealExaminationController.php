<?php

namespace App\Http\Controllers;

use App\Models\ConsultantAppealExamination;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class ConsultantAppealExaminationController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ConsultantAppealExamination::orderBy('CONSULTANT_APPEAL_EXAMINATION_ID','desc')->first();

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
            $data = ConsultantAppealExamination::all();

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
            ]);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EXAM_APPEAL_DAY' => 'required|integer'
        ]);

        try {
            $data = new ConsultantAppealExamination;
            $data->EXAM_APPEAL_DAY = $request->EXAM_APPEAL_DAY;
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
            ]);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

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
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        try {
            
            //update function

            http_response_code(200);
            return response([
                'message' => ''
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4101
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {

            $data = ConsultantAppealExamination::find($request->CONSULTANT_APPEAL_ID);
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
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Constants\TaskStatusConstants;
use DB;

class TaskStatusController extends Controller
{
    public function getActiveInactiveTaskStatus(){
        try {
            $data = DB::table('TASK_STATUS')
                ->select('TASK_STATUS.TS_PARAM', 'TASK_STATUS.TS_ID')
                ->where('TASK_STATUS.TS_CODE', TaskStatusConstants::TASK_GENERAL)
                ->whereIn('TASK_STATUS.TS_PARAM', TaskStatusConstants::ACTIVE_INACTIVE_STATUS)
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

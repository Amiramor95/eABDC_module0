<?php

namespace App\Http\Controllers;

use App\Models\DistApprovalLevel;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class DistApprovalLevelController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DistApprovalLevel::find($request->DistApprovalLevel_ID);

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

    public function getAllGroup()
    {
        try {

        $data = DB::table('MANAGE_SCREEN_ACCESS AS SA')
        ->select('SA.MANAGE_GROUP_ID', 'SA.MANAGE_SCREEN_ACCESS_ID', DB::raw("CONCAT(DEPARTMENT.DPMT_NAME, '-', GROUP1.GROUP_NAME) AS COMBINE"))
        ->leftJoin('MANAGE_GROUP AS GROUP1', 'GROUP1.MANAGE_GROUP_ID', '=', 'SA.MANAGE_GROUP_ID' )
        ->leftJoin('SETTING_GENERAL AS AUTH', 'AUTH.SETTING_GENERAL_ID', '=', 'SA.AUTHORIZATION_LEVEL_ID')
        ->leftJoin('MANAGE_DEPARTMENT AS DEPARTMENT', 'DEPARTMENT.MANAGE_DEPARTMENT_ID', '=', 'GROUP1.MANAGE_DEPARTMENT_ID')
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

    public function getAll(Request $request)
    {
        try {
            $data = DB::table('DIST_APPROVAL_LEVEL AS DIST_APPROVAL')
			->select('DIST_APPROVAL.DIST_APPROVAL_LEVEL_ID',
			'DIST_APPROVAL.DIST_APPR_LEVEL_NAME', 'DIST_APPROVAL.DIST_APPR_INDEX', 'DIST_APPROVAL.DIST_APPR_AUTO_REJECT_DAYS',
			'DIST_APPROVAL.DIST_APPR_AUTO_APPROVAL_DAYS', 'DIST_APPROVAL.DIST_APPR_PROCESSFLOW_ID', 
			DB::raw("CONCAT(MANAGE_DEPARTMENT.DPMT_NAME, '-', MANAGE_GROUP.GROUP_NAME) AS COMBINE"))
			->leftJoin('MANAGE_SCREEN_ACCESS AS SCREEN_ACCESS', 'SCREEN_ACCESS.MANAGE_GROUP_ID', '=', 'DIST_APPROVAL.DIST_APPR_GROUP_ID')
			->leftJoin('MANAGE_GROUP AS MANAGE_GROUP', 'MANAGE_GROUP.MANAGE_GROUP_ID', '=', 'SCREEN_ACCESS.MANAGE_GROUP_ID')
			->leftJoin('MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT', 'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID' , '=', 'MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
			->leftJoin('SETTING_GENERAL AS AUTH', 'AUTH.SETTING_GENERAL_ID', '=', 'SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID')
			->leftJoin('PROCESS_FLOW AS PROCESS_FLOW', 'PROCESS_FLOW.PROCESS_FLOW_ID', '=', 'DIST_APPROVAL.DIST_APPR_PROCESSFLOW_ID')
			->where('DIST_APPROVAL.DIST_APPR_PROCESSFLOW_ID',$request->DIST_APPR_PROCESSFLOW_ID)
			->where('DIST_APPROVAL.DIST_APPR_LEVEL_NAME', $request->DIST_APPR_LEVEL_NAME)
            ->orderBy('DIST_APPROVAL_LEVEL_ID', 'desc')
			->first();

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
            try {
            if($request->DIST_APPROVAL_LEVEL_ID == 0){
                $data = new DistApprovalLevel;
            }else{
                $data = DistApprovalLevel::find($request->DIST_APPROVAL_LEVEL_ID);
            }
            //$data = ApprovalLevel::find($request->APPROVAL_LEVEL_ID);
            $data->DIST_APPR_INDEX = $request->DIST_APPR_INDEX;
            $data->DIST_APPR_AUTO_APPROVAL_DAYS = $request->DIST_APPR_AUTO_APPROVAL_DAYS;
            $data->DIST_APPR_AUTO_REJECT_DAYS = $request->DIST_APPR_AUTO_REJECT_DAYS;
            $data->DIST_APPR_GROUP_ID = $request->DIST_APPR_GROUP_ID;
            $data->DIST_APPR_LEVEL_NAME = $request->DIST_APPR_LEVEL_NAME;
            $data->DIST_APPR_PROCESSFLOW_ID = $request->DIST_APPR_PROCESSFLOW_ID;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.',
                'data' => $data
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
            $data = DistApprovalLevel::where('id',$id)->first();
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
            $data = DistApprovalLevel::find($id);
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

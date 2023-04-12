<?php

namespace App\Http\Controllers;

use App\Models\ApprovalLevel;
use App\Models\DistApprovalLevel;
use App\Models\DistributorType;
use DB;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
//use App\Models\DistributorType;

class ApprovalLevelController extends Controller
{
    public function get(Request $request)
    {
        try {
			// $data = ApprovalLevel::find($request->APPROVAL_LEVEL_ID);
            $data = ApprovalLevel::where('APPR_PROCESSFLOW_NAME',$request->APPR_PROCESSFLOW_NAME)
            ->where('APPR_LEVEL_NAME', $request->APPR_LEVEL_NAME)
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

    public function getAllDepartment()
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

    public function getAllDistibutorType()
    {
        try {

        $data = DB::table('DISTRIBUTOR_TYPE AS DISTRIBUTOR')
        ->select('DISTRIBUTOR.DISTRIBUTOR_TYPE', 'DISTRIBUTOR.DIST_TYPE_NAME')
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
            $data = DB::table('APPROVAL_LEVEL AS APPROVAL_LEVEL')
			->select('APPROVAL_LEVEL.APPROVAL_LEVEL_ID',
			'APPROVAL_LEVEL.APPR_INDEX', 'APPROVAL_LEVEL.APPR_LEVEL_NAME', 'APPROVAL_LEVEL.APPR_AUTO_APPROVAL_DAYS',
			'APPROVAL_LEVEL.APPR_AUTO_REJECT_DAYS',
            'APPROVAL_LEVEL.APPR_PROCESSFLOW_ID',
            'APPROVAL_LEVEL.APPR_GROUP_ID',
            'APPROVAL_LEVEL.APPR_STATUS',
			DB::raw("CONCAT(MANAGE_DEPARTMENT.DPMT_NAME, '-', MANAGE_GROUP.GROUP_NAME)  AS COMBINE"))
			->leftJoin('MANAGE_SCREEN_ACCESS AS SCREEN_ACCESS', 'SCREEN_ACCESS.MANAGE_GROUP_ID', '=', 'APPROVAL_LEVEL.APPR_GROUP_ID')
			->leftJoin('MANAGE_GROUP AS MANAGE_GROUP', 'MANAGE_GROUP.MANAGE_GROUP_ID', '=', 'SCREEN_ACCESS.MANAGE_GROUP_ID')
			->leftJoin('MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT', 'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID' , '=', 'MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
			->leftJoin('SETTING_GENERAL AS AUTH', 'AUTH.SETTING_GENERAL_ID', '=', 'SCREEN_ACCESS.AUTHORIZATION_LEVEL_ID')
			->leftJoin('PROCESS_FLOW AS PROCESS_FLOW', 'PROCESS_FLOW.PROCESS_FLOW_ID', '=', 'APPROVAL_LEVEL.APPR_PROCESSFLOW_ID')
			->where('APPROVAL_LEVEL.APPR_PROCESSFLOW_ID',$request->APPR_PROCESSFLOW_ID)
			->where('APPROVAL_LEVEL.APPR_LEVEL_NAME', $request->APPR_LEVEL_NAME)
            ->orderBy('APPROVAL_LEVEL_ID', 'desc')
			->first();


        //    dd($request->APPR_PROCESSFLOW_NAME);

            // $distributorCategory = DistributorType::all();
            // // foreach($distributorCategory as $item){
            // //     $item->selected = false;
            // // }
            // foreach($data as $dataAppr){
            //     $list = array();
            //     // foreach($distributorCategory as $item){

            //         // foreach(json_decode($dataAppr->APPR_DISTRIBUTOR_CATEGORY) as $element){
            //             if(in_array($item->DISTRIBUTOR_TYPE_ID, json_decode($dataAppr->APPR_DISTRIBUTOR_CATEGORY))){
            //             // if($item->DISTRIBUTOR_TYPE_ID == $element){
            //              $item->selected = true;
            //              // $list[] = $item;
            //              $list[] = $item;
            //             }else{
            //             $item->selected = false;
            //             $list[] = $item;
            //             }
            //         // }

            //     }
            //     // dd($list);
            //     $dataAppr->list = $list;
            // }

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


    public function getByIndex (Request $request)
    {
        try {

            $data = ApprovalLevel::where('APPR_PROCESSFLOW_ID',$request->APPR_PROCESSFLOW_ID)
            ->where('APPR_INDEX',$request->APPR_INDEX)->get();


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
            if($request->APPROVAL_LEVEL_ID == 0){
                $data = new ApprovalLevel;
            }else{
                $data = ApprovalLevel::find($request->APPROVAL_LEVEL_ID);
            }
            //$data = ApprovalLevel::find($request->APPROVAL_LEVEL_ID);
            $data->APPR_INDEX = $request->APPR_INDEX;
            $data->APPR_AUTO_APPROVAL_DAYS = $request->APPR_AUTO_APPROVAL_DAYS;
            $data->APPR_AUTO_REJECT_DAYS = $request->APPR_AUTO_REJECT_DAYS;
            $data->APPR_GROUP_ID = $request->APPR_GROUP_ID;
            $data->APPR_LEVEL_NAME = $request->APPR_LEVEL_NAME;
            $data->APPR_PROCESSFLOW_ID = $request->APPR_PROCESSFLOW_ID;
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
$validator = Validator::make($request->all(), [
			'APPR_LEVEL_NAME' => 'string|nullable',
			'APPR_PREDECESSOR' => 'integer|nullable',
			'APPR_AUTO_APPROVAL_DAYS' => 'integer|nullable',
			'APPR_AUTO_REJECT_DAYS' => 'integer|nullable',
			'APPR_DISTRIBUTOR_CATEGORY' => 'string|nullable',
			'APPR_OTHERS_CATEGORY' => 'string|nullable',
			'APPR_PROCESSFLOW_NAME' => 'string|nullable',
			'APPR_STATUS' => 'required|integer',
			'APPR_INDEX' => 'required|integer',
			'CREATE_BY' => 'integer|nullable',
			'CREATE_TIMESTAMP' => 'integer|nullable'
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

            $data =ApprovalLevel::find($request->APPROVAL_LEVEL_ID);
            $data->APPR_GROUP_ID = $request->APPR_GROUP_ID;
            $data->APPR_INDEX = $request->APPR_INDEX;
            $data->APPR_AUTO_APPROVAL_DAYS = $request->APPR_AUTO_APPROVAL_DAYS;
            $data->APPR_AUTO_REJECT_DAYS = $request->APPR_AUTO_REJECT_DAYS;
            $data->APPR_DISTRIBUTOR_CATEGORY = $request->APPR_DISTRIBUTOR_CATEGORY;
            $data->APPR_STATUS = $request->APPR_STATUS;
            $data->APPR_PROCESSFLOW_ID = $request->APPR_PROCESSFLOW_ID;
            //$data->APPR_LEVEL_NAME = $request->APPR_LEVEL_NAME;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Updated'
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
            $data = ApprovalLevel::find($id);
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
			'APPR_LEVEL_NAME' => 'string|nullable',
			'APPR_PREDECESSOR' => 'integer|nullable',
			'APPR_AUTO_APPROVAL_DAYS' => 'integer|nullable',
			'APPR_AUTO_REJECT_DAYS' => 'integer|nullable',
			'APPR_DISTRIBUTOR_CATEGORY' => 'string|nullable',
			'APPR_OTHERS_CATEGORY' => 'string|nullable',
			'APPR_PROCESSFLOW_NAME' => 'string|nullable',
			'APPR_STATUS' => 'required|integer',
			'APPR_INDEX' => 'required|integer',
			'CREATE_BY' => 'integer|nullable',
			'CREATE_TIMESTAMP' => 'integer|nullable'
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\CircularEventApproval;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CircularEvent;
use App\Models\CircularEventDocument;
use App\Models\ManageCircular;
use App\Models\TaskStatus;
use DB;

class CircularEventApprovalController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = CircularEventApproval::find($request->CircularEventApproval_ID);

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
            $data = CircularEventApproval::all();

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

    public function CirculargetApprList(Request $request)
    {
        try {
			$data = DB::table('CIRCULAR_EVENT_APPROVAL AS APPROVAL')
            ->select ('APPROVAL.CIRCULAR_EVENT_APPROVAL_ID', 'EVENT.CIRCULAR_EVENT_ID', 'EVENT.EVENT_TITLE', 
            'EVENT.EVENT_DATE_START', 'EVENT.EVENT_DATE_END', 'EVENT.EVENT_DISTRIBUTOR_AUDIENCE', 
            'EVENT.EVENT_CONSULTANT_AUDIENCE', 'EVENT.EVENT_OTHER_AUDIENCE', 'USER.USER_NAME', 'TS.TS_PARAM')
            ->leftJoin('CIRCULAR_EVENT AS EVENT', 'EVENT.CIRCULAR_EVENT_ID', '=', 'APPROVAL.CIRCULAR_EVENT_ID')
            ->leftJoin('TASK_STATUS AS TS', 'TS.TS_ID', '=', 'APPROVAL.TS_ID')
            ->leftJoin('USER', 'USER.USER_ID', '=', 'EVENT.CREATE_BY')
            // ->where('APPROVAL.APPR_GROUP_ID', $request->APPR_GROUP_ID)
            ->where('APPROVAL.APPR_PUBLISH_STATUS', '0')
            ->where('EVENT.EVENT_TYPE', $request->EVENT_TYPE)
            ->get();

            // $distributorAudience = DistributorType::all();
            // foreach($distributorAudience as $distAudience){
            //     $distAudience->setSelected(false);
            //     foreach(json_decode($data->EVENT_DISTRIBUTOR_AUDIENCE) as $distAudiences){
            //         if($distAudience->DISTRIBUTOR_TYPE_ID == $distAudiences){
            //             $distAudience->setSelected(true);
            //         }
            //     }
            // }

            // $consultantAudience = ConsultantType::all();
            // foreach($consultantAudience as $consAudience){
            //     $consAudience->setSelected(false);
            //     if($data->EVENT_CONSULTANT_AUDIENCE != null){
            //         foreach(json_decode($data->EVENT_CONSULTANT_AUDIENCE) as $consAudiences){
            //             if($consAudience->CONSULTANT_TYPE_ID == $consAudiences){
            //                 $consAudience->setSelected(true);
            //             }
            //         }
            //     }
            // }

            // $otherAudience = SettingGeneral::where('SET_TYPE','USERCATEGORY')
            // ->where('SET_CODE','other')
            // ->get();
            // foreach($otherAudience as $OthAudience){
            //     $OthAudience->setSelected(false);
            //     if($data->EVENT_OTHER_AUDIENCE != null){
            //         foreach(json_decode($data->EVENT_OTHER_AUDIENCE) as $othAudiences){
            //             if($OthAudience->SETTING_GENERAL_ID == $othAudiences){
            //                 $OthAudience->setSelected(true);
            //             }
            //         }
            //     }
            // }

            // foreach($data as $element){
            //     $element->EVENT_DATE_START = date('d-M-Y', strtotime($element->EVENT_DATE_START));
            //     $element->EVENT_DATE_END = date('d-M-Y', strtotime($element->EVENT_DATE_END));
            // }

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
                // 'distributorAudience' => $distributorAudience,
                // 'consultantAudience' => $consultantAudience,
                // 'otherAudience' => $otherAudience
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function create(Request $request)
    {
    
        try {

            $approval = CircularEventApproval::find($request->CIRCULAR_EVENT_APPROVAL_ID);
            $approval->APPR_REMARK = $request->APPR_REMARK;
            $approval->CREATE_BY - $request->CREATE_BY;
            $approval->APPR_PUBLISH_STATUS = $request->APPR_PUBLISH_STATUS;
            $approval->TS_ID = $request->TS_ID;
            $approval->MANAGE_EVENT_ID = $request->MANAGE_EVENT_ID;
            $approval->save();

            $record = DB::table('CIRCULAR_EVENT_APPROVAL')
            ->select('CIRCULAR_EVENT_ID')
            ->where('CIRCULAR_EVENT_APPROVAL_ID', $request->CIRCULAR_EVENT_APPROVAL_ID)
            ->first();


            if($request->APPR_PUBLISH_STATUS == "1") {
                if($request->TS_ID == '3' ){
                    $secondApproval = new CircularEventApproval;
                    $secondApproval->CIRCULAR_EVENT_ID =  $record->CIRCULAR_EVENT_ID;
                    $secondApproval->TS_ID = $request->TS_ID;
                    $secondApproval->APPR_PUBLISH_STATUS = $request->APPR_PUBLISH_STATUS;
                    $secondApproval->save();
                }
            }

            $notification = new ManageNotification();
            $add = $notification->add($item->APPR_GROUP_ID,$item->APPR_PROCESSFLOW_ID,$request->NOTI_REMARK,$request->NOTI_LOCATION);


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

    public function update(Request $request, $id)
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
            $data = CircularEventApproval::where('id',$id)->first();
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
            $data = CircularEventApproval::find($id);
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

    public function getTaskStatus(){
        try {
            $data = DB::table('TASK_STATUS')->whereIn('TS_ID',[1,15,9,5,3])->get();

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
}

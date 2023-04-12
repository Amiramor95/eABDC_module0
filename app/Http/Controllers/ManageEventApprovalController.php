<?php

namespace App\Http\Controllers;

use App\Models\ManageEventApproval;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use App\Models\ManageAnnouncement;
use App\Helpers\ManageNotification;
use App\Models\ManageEvent;
use App\Models\ManageEventDocument;
use App\Models\DistributorType;
use App\Models\ConsultantType;
use App\Models\SettingGeneral;


class ManageEventApprovalController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = ManageEventApproval::find($request->MANAGE_EVENT_APPROVAL_ID); 

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

    public function getApprList(Request $request)
    {
        try {

			$data = DB::table('MANAGE_EVENT_APPROVAL AS APPROVAL')
            ->select ('APPROVAL.APPR_STATUS','APPROVAL.TS_ID','APPROVAL.MANAGE_EVENT_APPROVAL_ID', 'EVENT.MANAGE_EVENT_ID', 'EVENT.EVENT_TITLE', 
            'EVENT.EVENT_DATE_START', 'EVENT.EVENT_DATE_END', 'EVENT.EVENT_DISTRIBUTOR_AUDIENCE', 
            'EVENT.EVENT_CONSULTANT_AUDIENCE', 'EVENT.EVENT_OTHER_AUDIENCE', 'USER.USER_NAME', 'TS.TS_PARAM')
            ->leftJoin('MANAGE_EVENT AS EVENT', 'EVENT.MANAGE_EVENT_ID', '=', 'APPROVAL.MANAGE_EVENT_ID')
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

    public function getAll(Request $request)
    {
        try {
            $data = ManageEventApproval::select('*')
            ->leftJoin('MANAGE_EVENT', 'MANAGE_EVENT.MANAGE_EVENT_ID', '=', 'MANAGE_EVENT_APPROVAL.MANAGE_EVENT_ID')
            ->where('MANAGE_EVENT.EVENT_TYPE', $request->EVENT_TYPE)
            ->get;

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
        // $validator = Validator::make($request->all(), [ 
        // 			'MANAGE_EVENT_ID' => 'integer', 
        // 			'APPR_REMARK' => 'string', 
        // 			'APPR_STATUS' => 'integer', 
        // 			'CREATE_BY' => 'integer', 
        // 			'CREATE_TIMESTAMP' => 'integer' 
        //         ]);

        //         if ($validator->fails()) {
        //             http_response_code(400);
        //             return response([
        //                 'message' => 'Data validation error.',
        //                 'errorCode' => 4106
        //             ],400);
        //         }

        try {
            return $request->all();
           $approval = ManageEventApproval::find($request->MANAGE_EVENT_APPROVAL_ID);
           $approval->APPR_REMARK = $request->APPR_REMARK;
           $approval->CREATE_BY - $request->CREATE_BY;
           $approval->APPR_PUBLISH_STATUS = $request->APPR_PUBLISH_STATUS;
           $approval->TS_ID = $request->TS_ID;
           $approval->MANAGE_EVENT_ID = $request->MANAGE_EVENT_ID;
           $approval->save();

        //    $record = DB::table('MANAGE_EVENT')
        //    ->select('MANAGE_ANNOUCEMENT_ID')
        //    ->where('MANAGE_ANNOUCEMENT_ID', $request->MANAGE_ANNOUCEMENT_ID)
        //    ->first();

        //    $event = ManageEvent::find($request->MANAGE_EVENT_ID);
        //    $event->

        //    if($request->APPR_PUBLISH_STATUS == "1"){
        //        foreach(json_decode($request->MANAGE_ANNOUCEMENT) as $item){
        //         if($request->TS_ID != '1'){
        //             $updateStatus = new ManageAnnouncement;
        //             $updateStatus->MANAGE_EVENT_ID = $record->MANAGE_EVENT_ID;
        //             $updateStatus->APPR_GROUP_ID = $item->APPR_GROUP_ID;
        //             $updateStatus->TS_ID = $request->TS_ID;
        //             $updateStatus->save();
        //         }

        //        }
        //    }

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
        $validator = Validator::make($request->all(), [ 
			'MANAGE_EVENT_ID' => 'integer', 
			'APPR_REMARK' => 'string', 
			'APPR_STATUS' => 'integer', 
			'CREATE_BY' => 'integer', 
			'CREATE_TIMESTAMP' => 'integer' 
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
			'MANAGE_EVENT_ID' => 'integer', 
			'APPR_REMARK' => 'string', 
			'APPR_STATUS' => 'integer', 
			'CREATE_BY' => 'integer', 
			'CREATE_TIMESTAMP' => 'integer' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = ManageEventApproval::where('id',$id)->first();
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

    public function delete(Request $request)
    {
        try { 
            //return $request->all();
            $data = ManageEventApproval::find($request->MANAGE_EVENT_APPROVAL_ID);
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
			'MANAGE_EVENT_ID' => 'integer', 
			'APPR_REMARK' => 'string', 
			'APPR_STATUS' => 'integer', 
			'CREATE_BY' => 'integer', 
			'CREATE_TIMESTAMP' => 'integer' 
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

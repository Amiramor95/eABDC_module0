<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\CircularEvent;
use App\Models\CircularEventDocument;
use App\Models\ManageCircular;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use App\Models\DistributorType;
use App\Models\ConsultantType;
use App\Models\SettingGeneral;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\CircularEventApproval;
use App\Helpers\ManageNotification;
use App\Models\ManageDepartment;

class CircularEventController extends Controller
{ 
    // Get Circular data by id for edit
    public function get(Request $request)
    { 
        //return response($request->DEPARTMENT);
        try {
            $data = CircularEvent::select('CIRCULAR_EVENT.*','MANAGE_DEPARTMENT.DPMT_NAME')
            ->leftJoin('MANAGE_DEPARTMENT','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','CIRCULAR_EVENT.DEPARTMENT')
            ->where('CIRCULAR_EVENT.CIRCULAR_EVENT_ID', $request->CIRCULAR_EVENT_ID)
            ->get();
            $files = CircularEventDocument::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->get();

            foreach($files as $element){
                $element->DOC_BLOB = base64_encode($element->DOC_BLOB);
            };

            $appRemark = CircularEventApproval::select('*')
            ->where('CIRCULAR_EVENT_ID', $request->CIRCULAR_EVENT_ID)
            ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data,
                'files' =>  $files,
                'remark' => $appRemark
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
            $data = DB::table('admin_management.CIRCULAR_EVENT AS CE')
            ->select('CE.CIRCULAR_EVENT_ID',DB::raw('substr(CE.EVENT_TITLE, 1,40) as EVENT_TITLE'),'CE.EVENT_CONTENT','CE.EVENT_DATE_START','CE.EVENT_DATE_END',
            'CE.TS_ID','TS.TS_PARAM','USER.USER_NAME','CE.CREATE_TIMESTAMP','CE.PUBLISH_STATUS')

            ->leftJoin('admin_management.USER', 'USER.USER_ID', '=', 'CE.CREATE_BY')
            ->leftJoin('admin_management.TASK_STATUS AS TS','TS.TS_ID', '=', 'CE.TS_ID')

            ->where('CE.DEPARTMENT', $request->DEPARTMENT)
            ->get();



            foreach($data as $item){
                 if($item->CREATE_TIMESTAMP != null || $item->CREATE_TIMESTAMP != ""){
                    $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
                }else{
                $item->CREATE_TIMESTAMP = '-';
                }

                if($item->EVENT_DATE_END != null || $item->EVENT_DATE_END != ""){
                    $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                }else{
                $item->EVENT_DATE_END = '-';
                }

                
                if($item->EVENT_DATE_START != null || $item->EVENT_DATE_START != ""){
                    $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                }else{
                $item->EVENT_DATE_START = '-';
                }
                
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

    public function searchCircular(Request $request)
    {
        try {
            $data = DB::table('admin_management.CIRCULAR_EVENT AS CE')
            ->select('CE.CIRCULAR_EVENT_ID',DB::raw('substr(CE.EVENT_TITLE, 1,40) as EVENT_TITLE'),'CE.EVENT_CONTENT','CE.EVENT_DATE_START','CE.EVENT_DATE_END',
            'CE.TS_ID','TS.TS_PARAM','USER.USER_NAME','CE.CREATE_TIMESTAMP','CE.PUBLISH_STATUS')
            ->leftJoin('admin_management.USER', 'USER.USER_ID', '=', 'CE.CREATE_BY')
            ->leftJoin('admin_management.TASK_STATUS AS TS','TS.TS_ID', '=', 'CE.TS_ID')
            ->where('CE.DEPARTMENT', $request->DEPARTMENT);
            if($request->TITLE){
                $data->where('CE.EVENT_TITLE', 'like', '%'.$request->TITLE.'%'); 
            }
            if($request->STATUS){
                $data->where('CE.TS_ID', $request->STATUS);
            }
            $data = $data->get();



            foreach($data as $item){
                 if($item->CREATE_TIMESTAMP != null || $item->CREATE_TIMESTAMP != ""){
                    $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
                }else{
                $item->CREATE_TIMESTAMP = '-';
                }

                if($item->EVENT_DATE_END != null || $item->EVENT_DATE_END != ""){
                    $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                }else{
                $item->EVENT_DATE_END = '-';
                }

                
                if($item->EVENT_DATE_START != null || $item->EVENT_DATE_START != ""){
                    $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                }else{
                $item->EVENT_DATE_START = '-';
                }
                
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

    

    public function createNewCircular(Request $request)
    {  
        //return json_decode($request->APPR_LIST);
        try {
            // Data Validation 
            $rules =[];
            if ($request->input('EVENT_DATE_START') == "Invalid date") {
                $rules['EVENT_DATE_START'] = 'required|string';
            }
            if ($request->input('EVENT_DATE_END') == "Invalid date") {
                $rules['EVENT_DATE_END'] = 'required|string';
            }
            if ($request->input('EVENT_TITLE') == NULL) {
                $rules['EVENT_TITLE'] = 'required|string';
            }
            if ($request->input('EVENT_CONTENT') == NULL) {
                $rules['EVENT_CONTENT'] = 'required|string';
            }
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Please fill-up all required data !!.',
                    'errorCode' => 4106
                ],400);
            }

            $dataCircularEvent = new CircularEvent;
            $dataCircularEvent->EVENT_TITLE = $request->EVENT_TITLE;
            $dataCircularEvent->DEPARTMENT = $request->DEPARTMENT;
            $dataCircularEvent->EVENT_CONTENT = $request->EVENT_CONTENT;
            $dataCircularEvent->EVENT_DATE_START = $request->EVENT_DATE_START;
            $dataCircularEvent->EVENT_DATE_END = $request->EVENT_DATE_END;
            $dataCircularEvent->EVENT_DISTRIBUTOR_AUDIENCE = $request->EVENT_DISTRIBUTOR_AUDIENCE;
            //$dataCircularEvent->CREATE_BY = $request->CREATE_BY;
            $dataCircularEvent->TS_ID = $request->TS_ID;
            $dataCircularEvent->PUBLISH_STATUS = $request->PUBLISH_STATUS;
            $dataCircularEvent->save();

            
            $file = $request->file;
            if($request->hasFile('file')){
                foreach ($file as $item){            
                $itemFile = $item;
                $blob = $item->openFile()->fread($itemFile->getSize());
                $dataManageEventDoc = new CircularEventDocument;
                $dataManageEventDoc->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
                $dataManageEventDoc->DOC_BLOB = $blob;
                $dataManageEventDoc->DOC_MIMETYPE = $itemFile->getMimeType();
                $dataManageEventDoc->DOC_FILETYPE = $itemFile->getClientOriginalExtension();
                $dataManageEventDoc->DOC_ORIGINAL_NAME = $itemFile->getClientOriginalName();
                $dataManageEventDoc->DOC_FILESIZE = $itemFile->getSize();
                $dataManageEventDoc->save();
                }
            }
            $massage = "Data Successfully save as draft !!";
            
            // Circular Event Approval =====
            if($request->PUBLISH_STATUS == "1"){
                foreach(json_decode($request->APPR_LIST) as $item) {
                    $approval = new CircularEventApproval;
                    $approval->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
                    $approval->APPR_GROUP_ID = $item->APPR_GROUP_ID;
                    $approval->CREATE_BY = $request->CREATE_BY;
                    $approval->TS_ID = $request->TS_ID;
                    $approval->APPR_STATUS = $request->PUBLISH_STATUS;  
                    $approval->APPROVAL_LEVEL_ID = $item->APPROVAL_LEVEL_ID;
                    $approval->APPR_PUBLISH_STATUS = $request->PUBLISH_STATUS;
                    $approval->save();
                    // Notification to HDO
                    $notification = new ManageNotification();
                    $add = $notification->add(
                        $item->APPR_GROUP_ID, 
                        $item->APPR_PROCESSFLOW_ID,
                        $request->NOTI_REMARK, 
                        $request->NOTI_LOCATION
                    );    
                }
                $massage = "Data Successfully Published !!";
            }

            //create function
            http_response_code(200);
            return response([
                'message' => $massage 
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function updateNewCircular(Request $request)
    {  
        
        //return response($request->all()); 
        try {
            // Data Validation 
            $rules =[];
            if ($request->input('EVENT_DATE_START') == "Invalid date") {
                $rules['EVENT_DATE_START'] = 'required|string';
            }
            if ($request->input('EVENT_DATE_END') == "Invalid date") {
                $rules['EVENT_DATE_END'] = 'required|string';
            }
            if ($request->input('EVENT_TITLE') == NULL) {
                $rules['EVENT_TITLE'] = 'required|string';
            }
            if ($request->input('EVENT_CONTENT') == NULL) {
                $rules['EVENT_CONTENT'] = 'required|string';
            }
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Please fill-up all required data !!.',
                    'errorCode' => 4106
                ],400);
            }
            //1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED
            // $ifReturn = CircularEvent::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)
            //             ->where('PUBLISH_STATUS',3)
            //             ->orWhere('PUBLISH_STATUS',5)
            //             ->first();

            // if($ifReturn){
            //     $dataCircularEvent = new CircularEvent;
            // }else{
            //     $dataCircularEvent = CircularEvent::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->first();
            // } 

            $dataCircularEvent = CircularEvent::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->first();
            $dataCircularEvent->EVENT_TITLE = $request->EVENT_TITLE;
            //$dataCircularEvent->DEPARTMENT = $request->DEPARTMENT;
            $dataCircularEvent->EVENT_CONTENT = $request->EVENT_CONTENT;
            $dataCircularEvent->EVENT_DATE_START = $request->EVENT_DATE_START;
            $dataCircularEvent->EVENT_DATE_END = $request->EVENT_DATE_END;
            $dataCircularEvent->EVENT_DISTRIBUTOR_AUDIENCE = $request->EVENT_DISTRIBUTOR_AUDIENCE;
            //$dataCircularEvent->CREATE_BY = $request->CREATE_BY;
            $dataCircularEvent->TS_ID = $request->TS_ID;
            $dataCircularEvent->PUBLISH_STATUS = $request->PUBLISH_STATUS;
            $dataCircularEvent->save();

            
            $file = $request->file;
            if($request->hasFile('file')){
                CircularEventDocument::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->delete();
                foreach ($file as $item){            
                $itemFile = $item;
                $blob = $item->openFile()->fread($itemFile->getSize());
                $dataManageEventDoc = new CircularEventDocument;
                $dataManageEventDoc->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
                $dataManageEventDoc->DOC_BLOB = $blob;
                $dataManageEventDoc->DOC_MIMETYPE = $itemFile->getMimeType();
                $dataManageEventDoc->DOC_FILETYPE = $itemFile->getClientOriginalExtension();
                $dataManageEventDoc->DOC_ORIGINAL_NAME = $itemFile->getClientOriginalName();
                $dataManageEventDoc->DOC_FILESIZE = $itemFile->getSize();
                $dataManageEventDoc->save();
                }
            }
            $massage = "Data Successfully update as draft !!";
            // Circular Event Approval =====
            if($request->PUBLISH_STATUS == "1"){
                foreach(json_decode($request->APPR_LIST) as $item) {
                    $approval = new CircularEventApproval;
                    $approval->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
                    $approval->APPR_GROUP_ID = $item->APPR_GROUP_ID;
                    $approval->CREATE_BY = $request->CREATE_BY;
                    $approval->TS_ID = $request->TS_ID; 
                    $approval->APPR_STATUS = $request->PUBLISH_STATUS;
                    $approval->APPROVAL_LEVEL_ID = $item->APPROVAL_LEVEL_ID;
                    $approval->APPR_PUBLISH_STATUS = $request->PUBLISH_STATUS;
                    $approval->save();
                    // Notification to HDO
                    $notification = new ManageNotification();
                    $add = $notification->add(
                        $item->APPR_GROUP_ID, 
                        $item->APPR_PROCESSFLOW_ID,
                        $request->NOTI_REMARK, 
                        $request->NOTI_LOCATION
                    );   
                }
                $massage = "Data Successfully Published !!";
            }

            //create function
            http_response_code(200);
            return response([
                'message' => $massage 
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function reviewCircularUpdate(Request $request)
    {  
        
        //return response($request->all()); 
        try {
            // Data Validation 
            $rules =[];
            if ($request->input('REMARK_CONTENT') == NULL) {
                $rules['REMARK_CONTENT'] = 'required|string';
            }
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Please fill-up all required data !!.',
                    'errorCode' => 4106
                ],400);
            }
            $massage = "";
            //PUBLISH_STATUS:  1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 
            //PUBLISH_STATUS : 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED	
            $dataCircularEvent = CircularEvent::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->first();
            $dataCircularEvent->TS_ID = $request->TS_ID;
            $dataCircularEvent->CREATE_BY = $request->CREATE_BY;
            if( $request->PUBLISH_STATUS == "2"){
                $dataCircularEvent->PUBLISH_STATUS = 2;
                $massage = "Data Successfully Approved !!";
            }else if($request->PUBLISH_STATUS == "7"){
                $dataCircularEvent->PUBLISH_STATUS = 7;
                $massage = "Data Successfully Save As Draft !!";
            }else{
                $dataCircularEvent->PUBLISH_STATUS = 3;
                $massage = "Data Successfully Returned !!";
            }
            $dataCircularEvent->save();
            // Update Circular Approval table
            $updateAppr = CircularEventApproval::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)
                        ->where('APPR_PUBLISH_STATUS',1) 
                        ->first();         
            $updateAppr->APPR_REMARK = $request->REMARK_CONTENT;
            if( $request->PUBLISH_STATUS == "2"){
                $updateAppr->APPR_STATUS = 2;
            }else if($request->PUBLISH_STATUS == "7"){
                $updateAppr->APPR_STATUS = 7;
            }else{
                $updateAppr->APPR_STATUS = 3;
            }
            $updateAppr->save();         

            //Circular Event Approval =====
            if($request->TS_ID == "3"){
                foreach(json_decode($request->APPR_LIST) as $item) {
                    //if($item->APPR_GROUP_ID == 3 && $item->APPROVAL_LEVEL_ID == 104){   
                        $approval = new CircularEventApproval;
                        $approval->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
                        $approval->APPR_GROUP_ID = $item->APPR_GROUP_ID;
                        $approval->CREATE_BY = $request->CREATE_BY;
                        $approval->TS_ID = $request->TS_ID;
                        //$approval->APPR_REMARK = $request->REMARK_CONTENT;
                        $approval->APPR_STATUS = 2; 
                        $approval->APPROVAL_LEVEL_ID = $item->APPROVAL_LEVEL_ID;
                        $approval->APPR_PUBLISH_STATUS = 2;
                        $approval->save();
                        // Notification to GM
                        $notification = new ManageNotification();
                        $add = $notification->add(
                            $item->APPR_GROUP_ID, 
                            $item->APPR_PROCESSFLOW_ID,
                            $request->NOTI_REMARK, 
                            $request->NOTI_LOCATION
                        );
                        //return $add->NOTIFICATION_ID;
                        // $noti = DB::table('NOTIFICATION')
                        //     ->where('NOTIFICATION_ID', $add->NOTIFICATION_ID)
                        //     ->update([
                        //         'REMARK' => $request->NOTI_REMARK,
                        //         'LOCATION' => $request->NOTI_LOCATION
                        //     ]);
                    //}    
                }
                
            }

            //create function
            http_response_code(200);
            return response([
                'message' => $massage 
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function gmReviewCircularUpdate(Request $request)
    {  
        
        //return response($request->all()); 
        try {
            // Data Validation 
            $rules =[];
            if ($request->input('REMARK_CONTENT') == NULL) {
                $rules['REMARK_CONTENT'] = 'required|string';
            }
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Please fill-up all required data !!.',
                    'errorCode' => 4106
                ],400);
            } 
            $massage = "";
            //PUBLISH_STATUS:  1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 
            //PUBLISH_STATUS : 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED	
            $dataCircularEvent = CircularEvent::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->first();
            $dataCircularEvent->TS_ID = $request->TS_ID;
            if($request->PUBLISH_STATUS == "4"){
                $dataCircularEvent->PUBLISH_STATUS = 4;
                $massage = "Data Successfully Approved !!";
            }else if($request->PUBLISH_STATUS == "8"){
                $dataCircularEvent->PUBLISH_STATUS = 8;
                $massage = "Data Successfully Save As Draft !!";
            }else{
                $dataCircularEvent->PUBLISH_STATUS = 5;
                $massage = "Data Successfully Returned !!";
            }
            $dataCircularEvent->save();
            // Update Circular Approval table
            $updateAppr = CircularEventApproval::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)
                        ->where('APPR_PUBLISH_STATUS',2) 
                        ->first();
            $updateAppr->APPR_REMARK = $request->REMARK_CONTENT;
            if( $request->PUBLISH_STATUS == "4"){
                $updateAppr->APPR_STATUS = 4;
            }else if($request->PUBLISH_STATUS == "8"){
                $updateAppr->APPR_STATUS = 8;
            }else{
                $updateAppr->APPR_STATUS = 5;
            }
            $updateAppr->save();         

            //create function
            http_response_code(200);
            return response([
                'message' => $massage 
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function circularDelete(Request $request)
    { //return $request->all();
        try {
            $data = CircularEvent::find($request->CIRCULAR_EVENT_ID);
            $data->delete();
            CircularEventDocument::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->delete();

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
            $dataCircular =  ManageCircular::find($request->MANAGE_CIRCULAR_ID);
            $dataCircular->MANAGE_DEPARTMENT_ID = $request->MANAGE_DEPARTMENT_ID;
            $dataCircular->CIRCULAR_STATUS = $request->CIRCULAR_STATUS;
            $dataCircular->save();

            $dataCircularEvent = CircularEvent::find($request->CIRCULAR_EVENT_ID);
            $dataCircularEvent->MANAGE_CIRCULAR_ID = $dataCircular->MANAGE_CIRCULAR_ID;
            $dataCircularEvent->EVENT_TITLE = $request->EVENT_TITLE;
            //$dataCircularEvent->EVENT_TYPE = $request->EVENT_TYPE;
            $dataCircularEvent->EVENT_CONTENT	 = $request->EVENT_CONTENT;
            $dataCircularEvent->EVENT_DATE_START = $request->EVENT_DATE_START;
            $dataCircularEvent->EVENT_DATE_END = $request->EVENT_DATE_END;
            $dataCircularEvent->EVENT_DISTRIBUTOR_AUDIENCE = $request->EVENT_DISTRIBUTOR_AUDIENCE;
            $dataCircularEvent->EVENT_CONSULTANT_AUDIENCE = $request->EVENT_CONSULTANT_AUDIENCE;
            $dataCircularEvent->EVENT_OTHER_AUDIENCE = $request->EVENT_OTHER_AUDIENCE;
            $dataCircularEvent->CREATE_BY = $request->CREATE_BY;
            $dataCircularEvent->save();

            if($request->isFile == 1){
            $file = $request->file;
            foreach ($file as $item){            
            $itemFile = $item;
            $blob = $item->openFile()->fread($itemFile->getSize());
            $dataManageEventDoc = new CircularEventDocument;
            $dataManageEventDoc->CIRCULAR_EVENT_ID = $dataCircularEvent->CIRCULAR_EVENT_ID;
            $dataManageEventDoc->DOC_BLOB = $blob;
            $dataManageEventDoc->DOC_MIMETYPE = $itemFile->getMimeType();
            $dataManageEventDoc->DOC_ORIGINAL_NAME	 = $itemFile->getClientOriginalName();
            //$dataManageEventDoc->DOC_FILEPATH = $destinationPath;
            $dataManageEventDoc->DOC_FILESIZE = $itemFile->getSize();
            $dataManageEventDoc->CREATE_BY = $request->CREATE_BY;
            $dataManageEventDoc->save();
            }
        }


        } 
        catch (RequestException $r) {

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
            $data = CircularEvent::find($id);

            $data_doc = CircularEventDocument::where('CIRCULAR_EVENT_ID',$request->CIRCULAR_EVENT_ID)->delete();
            $data = CircularEvent::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->delete();

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

    public function getAllReviewCircular(Request $request)
    {
        //return $request->all();
        try {
            $data = DB::table('admin_management.CIRCULAR_EVENT AS CE')
            ->select('CE.CIRCULAR_EVENT_ID',DB::raw('substr(CE.EVENT_TITLE, 1,40) as EVENT_TITLE'),'CE.EVENT_CONTENT','CE.EVENT_DATE_START','CE.EVENT_DATE_END',
            'CE.TS_ID','TS.TS_PARAM','USER.USER_NAME','CE.CREATE_TIMESTAMP','CE.PUBLISH_STATUS')
            ->leftJoin('admin_management.USER', 'USER.USER_ID', '=', 'CE.CREATE_BY')
            ->leftJoin('admin_management.TASK_STATUS AS TS','TS.TS_ID', '=', 'CE.TS_ID')
            ->where('CE.DEPARTMENT',$request->MANAGE_DEPARTMENT_ID)
            ->whereIn('CE.TS_ID', [15,9,5,3])
            ->orderBy('CE.CREATE_TIMESTAMP', 'desc');
            if($request->TITLE){
                $data->where('CE.EVENT_TITLE', 'like', '%'.$request->TITLE.'%'); 
            }
            if($request->STATUS){
                $data->where('CE.TS_ID', $request->STATUS);
            }
            $data = $data->get();



            foreach($data as $item){
                 if($item->CREATE_TIMESTAMP != null || $item->CREATE_TIMESTAMP != ""){
                    $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
                }else{
                $item->CREATE_TIMESTAMP = '-';
                }

                if($item->EVENT_DATE_END != null || $item->EVENT_DATE_END != ""){
                    $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                }else{
                $item->EVENT_DATE_END = '-';
                }

                
                if($item->EVENT_DATE_START != null || $item->EVENT_DATE_START != ""){
                    $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                }else{
                $item->EVENT_DATE_START = '-';
                }
                
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

    public function getGmReviewCircular(Request $request)
    {
        //PUBLISH_STATUS:: 1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED
        try {
            $data = DB::table('admin_management.CIRCULAR_EVENT AS CE')
            ->select('CE.CIRCULAR_EVENT_ID',DB::raw('substr(CE.EVENT_TITLE, 1,40) as EVENT_TITLE'),'CE.EVENT_CONTENT','CE.EVENT_DATE_START','CE.EVENT_DATE_END',
            'CE.TS_ID','TS.TS_PARAM','USER.USER_NAME','CE.CREATE_TIMESTAMP','CE.PUBLISH_STATUS')
            ->leftJoin('admin_management.USER', 'USER.USER_ID', '=', 'CE.CREATE_BY')
            ->leftJoin('admin_management.TASK_STATUS AS TS','TS.TS_ID', '=', 'CE.TS_ID')
            ->where('CE.DEPARTMENT',$request->MANAGE_DEPARTMENT_ID)
            ->whereIn('CE.TS_ID', [15,9,5,3])
            ->whereIn('CE.PUBLISH_STATUS', [2,4,5,6,8]) 
            ->orderBy('CE.CREATE_TIMESTAMP', 'desc');
            if($request->TITLE){
                $data->where('CE.EVENT_TITLE', 'like', '%'.$request->TITLE.'%'); 
            }
            if($request->STATUS){
                $data->where('CE.TS_ID', $request->STATUS);
            }
            $data = $data->get();



            foreach($data as $item){
                 if($item->CREATE_TIMESTAMP != null || $item->CREATE_TIMESTAMP != ""){
                    $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
                }else{
                $item->CREATE_TIMESTAMP = '-';
                }

                if($item->EVENT_DATE_END != null || $item->EVENT_DATE_END != ""){
                    $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                }else{
                $item->EVENT_DATE_END = '-';
                }

                
                if($item->EVENT_DATE_START != null || $item->EVENT_DATE_START != ""){
                    $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                }else{
                $item->EVENT_DATE_START = '-';
                }
                
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

    public function setCircularStatus(Request $request)
    { 
        //return $request->all();

        try {
            
            $result = DB::table('MANAGE_CIRCULAR')->updateOrInsert(
                ['MANAGE_DEPARTMENT_ID' =>  $request->DEPT_ID],
                [
                    'MANAGE_DEPARTMENT_ID' => $request->DEPT_ID,
                    'CIRCULAR_STATUS' => ($request->STATUS == 'false') ? 0 : 1,
                ]
            );
        
            http_response_code(200);
            return response([
                'message' =>  'Data successfully saved !'
            ]);
            

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function getCircularDepartment()
    {
        try {
            //$department = ManageDepartment::all();
            $department = DB::table('MANAGE_DEPARTMENT')
            ->select('*','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS MANAGE_DEPARTMENT_ID')
            ->leftJoin(
                'MANAGE_CIRCULAR', 
                'MANAGE_CIRCULAR.MANAGE_DEPARTMENT_ID',
                'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID'
            )
            ->get();
           
            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $department
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function getCircularByDepartmentID(Request $request)
    { 
        //return response($request->DEPARTMENT);
        try {
            $data = CircularEvent::select('CIRCULAR_EVENT.EVENT_TITLE AS EVENT_TITLE','CIRCULAR_EVENT.CIRCULAR_EVENT_ID AS CIRCULAR_EVENT_ID','CIRCULAR_EVENT.DEPARTMENT AS DEPARTMENT')
            ->where('CIRCULAR_EVENT.DEPARTMENT', $request->USER_DEPARTMENT_ID)
            ->where('CIRCULAR_EVENT.PUBLISH_STATUS', 4)
            ->where('CIRCULAR_EVENT.TS_ID', 3)
            ->orderBy('CIRCULAR_EVENT.CREATE_TIMESTAMP', 'desc')
            ->take(5)
            ->get();
           
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data,
              //  'files' =>  $files,
               // 'remark' => $appRemark
            ]);

        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function getDepartment(Request $request)
    {
        try {
            $department = ManageDepartment::select('*')
            ->where('MANAGE_DEPARTMENT_ID',$request->USER_DEPARTMENT_ID)
            ->first();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $department
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }
    public function getAllApproved(Request $request)
    {
        try {
            $data = DB::table('admin_management.CIRCULAR_EVENT AS CE')
            ->select('CE.CIRCULAR_EVENT_ID',DB::raw('substr(CE.EVENT_TITLE, 1,40) as EVENT_TITLE'),'CE.EVENT_CONTENT','CE.EVENT_DATE_START','CE.EVENT_DATE_END',
            'CE.TS_ID','TS.TS_PARAM','USER.USER_NAME','CE.CREATE_TIMESTAMP','CE.PUBLISH_STATUS')

            ->leftJoin('admin_management.USER', 'USER.USER_ID', '=', 'CE.CREATE_BY')
            ->leftJoin('admin_management.TASK_STATUS AS TS','TS.TS_ID', '=', 'CE.TS_ID')
            ->where('CE.PUBLISH_STATUS', 4)
            ->where('CE.TS_ID', 3)
            ->where('CE.DEPARTMENT', $request->DEPARTMENT)
            ->get();



            foreach($data as $item){
                 if($item->CREATE_TIMESTAMP != null || $item->CREATE_TIMESTAMP != ""){
                    $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
                }else{
                $item->CREATE_TIMESTAMP = '-';
                }

                if($item->EVENT_DATE_END != null || $item->EVENT_DATE_END != ""){
                    $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                }else{
                $item->EVENT_DATE_END = '-';
                }

                
                if($item->EVENT_DATE_START != null || $item->EVENT_DATE_START != ""){
                    $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                }else{
                $item->EVENT_DATE_START = '-';
                }
                
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
}
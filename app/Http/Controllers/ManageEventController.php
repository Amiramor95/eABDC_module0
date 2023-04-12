<?php

namespace App\Http\Controllers;
use App\Models\DistributorType;
use App\Models\ConsultantType;
use App\Models\SettingGeneral;
use App\Models\ManageAnnouncement;
use App\Models\ManageEvent;
use App\Models\ManageEventDocument;
use App\Models\ManageEventApproval;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Validator;
use Storage;
use File;
use App\Helpers\Files;
use App\Http\Controllers\FileUpload;
use App\Helpers\ManageNotification;

class ManageEventController extends Controller
{
    public function get(Request $request)
    {
        //return $request->all();
        try {
			$data = ManageEvent::select('MANAGE_EVENT.MANAGE_EVENT_ID','MANAGE_EVENT.EVENT_TITLE',
            'MANAGE_EVENT.EVENT_CONTENT','MANAGE_EVENT.EVENT_DATE_START','MANAGE_EVENT.EVENT_DATE_END',
            'MANAGE_EVENT.MANAGE_EVENT_ID','MANAGE_EVENT.EVENT_DISTRIBUTOR_AUDIENCE','MANAGE_EVENT.EVENT_CONSULTANT_AUDIENCE',
            'MANAGE_EVENT.EVENT_OTHER_AUDIENCE','MANAGE_ANNOUNCEMENT.ANNOUNCEMENT_STATUS','MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID')
            ->join('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->where('MANAGE_EVENT.MANAGE_EVENT_ID', $request->MANAGE_EVENT_ID)
            ->first();


            $files = ManageEventDocument::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->get();
            // $files->map(function($file, $key) {									
            //     return [
            //             'DOC_BLOB' => base64_encode($file->DOC_BLOB)
            //         ];
            // });

            foreach($files as $element){
                $element->DOC_BLOB = base64_encode($element->DOC_BLOB);
            };

            // $document = ManageEventDocument::select('*')
            // ->where('MANAGE_EVENT_DOCUMENT.MANAGE_EVENT_ID', $request->MANAGE_EVENT_ID)
            // ->get();

            $distributorAudience = DistributorType::all();
            foreach($distributorAudience as $distAudience){
                $distAudience->setSelected(false);
                foreach(json_decode($data->EVENT_DISTRIBUTOR_AUDIENCE) as $distAudiences){
                    if($distAudience->DISTRIBUTOR_TYPE_ID == $distAudiences){
                        $distAudience->setSelected(true);
                    }
                }
            }

            $consultantAudience = ConsultantType::all();
            foreach($consultantAudience as $consAudience){
                $consAudience->setSelected(false);
                if($data->EVENT_CONSULTANT_AUDIENCE != null){
                    foreach(json_decode($data->EVENT_CONSULTANT_AUDIENCE) as $consAudiences){
                        if($consAudience->CONSULTANT_TYPE_ID == $consAudiences){
                            $consAudience->setSelected(true);
                        }
                    }
                }
            }

            $otherAudience = SettingGeneral::where('SET_TYPE','USERCATEGORY')
            ->where('SET_CODE','other')
            ->get();
            foreach($otherAudience as $OthAudience){
                $OthAudience->setSelected(false);
                if($data->EVENT_OTHER_AUDIENCE != null){
                    foreach(json_decode($data->EVENT_OTHER_AUDIENCE) as $othAudiences){
                        if($OthAudience->SETTING_GENERAL_ID == $othAudiences){
                            $OthAudience->setSelected(true);
                        }
                    }
                }
            }

            $fileReader = new Files();

            $result = $fileReader->getFile($request);

            //  $fileObject = response()->file(storage_path('app/public/event-document/83_29_template example 1.pdf'));
            //  return $fileObject;
            // $destinationPath = storage_path('app/public/test');
            // $result->move($destinationPath, 'test'.$result->getClientOriginalExtension());
             //dd($result);


         //dd($result);
          // return response()->file(storage_path('app/public/event-document/83_29_template example 1.pdf'));
        //   return $result;

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'event' => $data, 
                    //'document' => $document,
                    'distributorAudience' =>  $distributorAudience,
                    'consultantAudience' => $consultantAudience,
                    'otherAudience' => $otherAudience,
                    'files' =>  $files
                ]),
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function getAnnById(Request $request){

        //return response($request->all());
        try {
            $data = ManageEvent::select(
                'MANAGE_EVENT.DEPARTMENT AS DEPARTMENT',
                'MANAGE_EVENT.MANAGE_EVENT_ID',
                'MANAGE_EVENT.EVENT_TITLE',
                'MANAGE_DEPARTMENT.DPMT_NAME',
                'MANAGE_EVENT.EVENT_CONTENT',
                'MANAGE_EVENT.EVENT_DATE_START',
                'MANAGE_EVENT.EVENT_DATE_END',
                'MANAGE_EVENT.PUBLISH_STATUS',
                'MANAGE_EVENT.MANAGE_EVENT_ID',
                'MANAGE_EVENT.EVENT_DISTRIBUTOR_AUDIENCE',
                'MANAGE_EVENT.EVENT_CONSULTANT_AUDIENCE',
                'MANAGE_EVENT.EVENT_OTHER_AUDIENCE',
                'MANAGE_EVENT_APPROVAL.APPR_REMARK'
            )
            //->leftJoin('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->leftJoin('MANAGE_DEPARTMENT','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','MANAGE_EVENT.DEPARTMENT')
            ->leftJoin('MANAGE_EVENT_APPROVAL','MANAGE_EVENT_APPROVAL.MANAGE_EVENT_ID','MANAGE_EVENT.MANAGE_EVENT_ID')
            ->where('MANAGE_EVENT.MANAGE_EVENT_ID', $request->MANAGE_EVENT_ID)
            ->get();

            $files = ManageEventDocument::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->get();
            foreach($files as $element){
                $element->DOCUMENT_BLOB = base64_encode($element->DOCUMENT_BLOB);
            };

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data ? $data : [],
                'files' =>  $files
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
        //return $request->all();
        try {
            $data = ManageEvent::select('MANAGE_EVENT.MANAGE_EVENT_ID',DB::raw('substr(MANAGE_EVENT.EVENT_TITLE, 1,40) as EVENT_TITLE'),'MANAGE_EVENT.EVENT_CONTENT','MANAGE_EVENT.EVENT_DATE_START',
            'MANAGE_EVENT.EVENT_DATE_END', 'USER.USER_NAME','MANAGE_EVENT.CREATE_TIMESTAMP','STATUS.TS_ID',
            'MANAGE_EVENT.PUBLISH_STATUS','DEPT.DPMT_NAME','STATUS.TS_PARAM')
            //->leftJoin('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->leftJoin('USER', 'USER.USER_ID', '=', 'MANAGE_EVENT.CREATE_BY' )
            //->join('MANAGE_EVENT_DOCUMENT', 'MANAGE_EVENT_DOCUMENT.MANAGE_EVENT_ID', '=', 'MANAGE_EVENT.MANAGE_EVENT_ID')
            ->leftJoin('TASK_STATUS AS STATUS', 'STATUS.TS_ID', '=', 'MANAGE_EVENT.TS_ID')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT', 'DEPT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_EVENT.DEPARTMENT')
            
            //->orderBy('MANAGE_EVENT.CREATE_TIMESTAMP', 'desc')
            ->where('MANAGE_EVENT.DEPARTMENT', $request->DEPARTMENT)
            ->get();

            foreach($data as $item){
                $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
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

    public function getAllReviewAnnouncement(Request $request)
    {
        //return $request->all();
        
        try {
            $data = ManageEvent::select('MANAGE_EVENT.MANAGE_EVENT_ID','MANAGE_EVENT.EVENT_TITLE','MANAGE_EVENT.EVENT_CONTENT','MANAGE_EVENT.EVENT_DATE_START',
            'MANAGE_EVENT.EVENT_DATE_END', 'USER.USER_NAME','MANAGE_EVENT.CREATE_TIMESTAMP','STATUS.TS_ID',
            'MANAGE_EVENT.PUBLISH_STATUS','DEPT.DPMT_NAME','STATUS.TS_PARAM')
            //->leftJoin('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->leftJoin('USER', 'USER.USER_ID', '=', 'MANAGE_EVENT.CREATE_BY' )
            //->join('MANAGE_EVENT_DOCUMENT', 'MANAGE_EVENT_DOCUMENT.MANAGE_EVENT_ID', '=', 'MANAGE_EVENT.MANAGE_EVENT_ID')
            ->leftJoin('TASK_STATUS AS STATUS', 'STATUS.TS_ID', '=', 'MANAGE_EVENT.TS_ID')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT', 'DEPT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_EVENT.DEPARTMENT')
            ->whereIn('MANAGE_EVENT.TS_ID', [15,9,5,3])
            ->orderBy('MANAGE_EVENT.CREATE_TIMESTAMP', 'desc')
            ->where('MANAGE_EVENT.DEPARTMENT', $request->DEPARTMENT);
            if($request->TITLE){
                $data->where('MANAGE_EVENT.EVENT_TITLE', 'like', '%'.$request->TITLE.'%'); 
            }
            if($request->STATUS){
                $data->where('MANAGE_EVENT.TS_ID', $request->STATUS);
            }
            $data = $data->get();

            foreach($data as $item){
                $item->EVENT_DATE_START = date('d M Y', strtotime($item->EVENT_DATE_START));
                $item->EVENT_DATE_END = date('d M Y', strtotime($item->EVENT_DATE_END));
                $item->CREATE_TIMESTAMP = date('d M Y', strtotime($item->CREATE_TIMESTAMP));
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

    
    public function searchAnnouceManagement(Request $request)
    { 
        //return $request->all
        try {
            $data = ManageEvent::select(
                'MANAGE_EVENT.MANAGE_EVENT_ID',
                DB::raw('substr(MANAGE_EVENT.EVENT_TITLE, 1,40) as EVENT_TITLE'),
                'MANAGE_EVENT.EVENT_CONTENT',
                'MANAGE_EVENT.EVENT_DATE_START',
                'MANAGE_EVENT.EVENT_DATE_END', 
                'USER.USER_NAME',
                'MANAGE_EVENT.CREATE_TIMESTAMP',
                'STATUS.TS_ID',
                'MANAGE_EVENT.PUBLISH_STATUS',
                'DEPT.DPMT_NAME',
                'STATUS.TS_PARAM'
            )
            ->leftJoin('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->leftJoin('USER', 'USER.USER_ID', '=', 'MANAGE_EVENT.CREATE_BY' )
            //->join('MANAGE_EVENT_DOCUMENT', 'MANAGE_EVENT_DOCUMENT.MANAGE_EVENT_ID', '=', 'MANAGE_EVENT.MANAGE_EVENT_ID')
            ->leftJoin('TASK_STATUS AS STATUS', 'STATUS.TS_ID', '=', 'MANAGE_EVENT.TS_ID')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT', 'DEPT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_EVENT.DEPARTMENT')
            ->where('MANAGE_EVENT.DEPARTMENT', $request->DEPARTMENT);
            if($request->TITLE){
                $data->where('MANAGE_EVENT.EVENT_TITLE', 'like', '%'.$request->TITLE.'%'); 
            }
            if($request->STATUS){
                $data->where('MANAGE_EVENT.TS_ID', $request->STATUS);
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

    public function create(Request $request)
    { 
        //return $request->all();

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

        try {
            
            $dataManageEvent = new ManageEvent;
            $dataManageEvent->EVENT_TITLE = $request->EVENT_TITLE;
            $dataManageEvent->DEPARTMENT = $request->DEPARTMENT;
            $dataManageEvent->TS_ID = $request->TS_ID;
            $dataManageEvent->EVENT_CONTENT	 = $request->EVENT_CONTENT;
            $dataManageEvent->EVENT_DATE_START = $request->EVENT_DATE_START;
            $dataManageEvent->EVENT_DATE_END = $request->EVENT_DATE_END;
            $dataManageEvent->EVENT_DISTRIBUTOR_AUDIENCE = $request->EVENT_DISTRIBUTOR_AUDIENCE;
            $dataManageEvent->EVENT_CONSULTANT_AUDIENCE = $request->EVENT_CONSULTANT_AUDIENCE;
            $dataManageEvent->EVENT_OTHER_AUDIENCE = $request->EVENT_OTHER_AUDIENCE;
            //$dataManageEvent->CREATE_BY = $request->CREATE_BY;
            $dataManageEvent->PUBLISH_STATUS = $request->PUBLISH_STATUS;
            $dataManageEvent->save();

            // File Upload =======
            $file = $request->file;
            if($request->hasFile('file')){
                foreach ($file as $item){            
                    $itemFile = $item;
                    $blob = $item->openFile()->fread($itemFile->getSize());
                    $dataManageEventDoc = new ManageEventDocument;
                    $dataManageEventDoc->MANAGE_EVENT_ID = $dataManageEvent->MANAGE_EVENT_ID;
                    $dataManageEventDoc->DOCUMENT_BLOB = $blob;
                    $dataManageEventDoc->DOCUMENT_MIMETYPE = $itemFile->getMimeType();
                    $dataManageEventDoc->DOCUMENT_FILETYPE = $itemFile->getClientOriginalExtension();
                    $dataManageEventDoc->DOCUMENT_FILENAME = $itemFile->getClientOriginalName();
                    $dataManageEventDoc->DOCUMENT_FILESIZE = $itemFile->getSize();
                    $dataManageEventDoc->CREATE_BY = $request->CREATE_BY;
                    $dataManageEventDoc->save();
                }
            }
            $massage = "Data Successfully save as draft !!";

            //approval data here=======
            if($request->PUBLISH_STATUS == "1"){
                foreach(json_decode($request->APPR_LIST) as $item) {   
                    //if($item->APPR_GROUP_ID == 2 && $item->APPROVAL_LEVEL_ID == 90){        
                        $approval = new ManageEventApproval;
                        $approval->MANAGE_EVENT_ID = $dataManageEvent->MANAGE_EVENT_ID;
                        $approval->APPR_GROUP_ID = $item->APPR_GROUP_ID;
                        $approval->CREATE_BY = $request->CREATE_BY;
                        $approval->TS_ID = $request->TS_ID; 
                        $approval->APPROVAL_LEVEL_ID = $item->APPROVAL_LEVEL_ID;
                        $approval->APPR_PUBLISH_STATUS = $request->PUBLISH_STATUS;
                        $approval->APPR_STATUS = $request->PUBLISH_STATUS;
                        $approval->save();

                        // Notification
                        $notification = new ManageNotification();
                        $add = $notification->add(
                            $item->APPR_GROUP_ID,
                            $item->APPR_PROCESSFLOW_ID,
                            $request->NOTI_REMARK,
                            $request->NOTI_LOCATION
                        );
                        //return $add->NOTIFICATION_ID;
                        // $noti = DB::table('NOTIFICATION')
                        // ->where('NOTIFICATION_ID', $add->NOTIFICATION_ID)
                        // ->update([
                        //     'REMARK' => $request->NOTI_REMARK,
                        //     'LOCATION' => $request->NOTI_LOCATION
                        // ]);
                    //}    
                    
                }
                $massage = "Data Successfully Published !!"; 
            }    
        
            http_response_code(200);
            return response([
                'message' =>  $massage
            ]);
            

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'MANAGE_ANNOUNCEMENT_ID' => 'integer|nullable', 
			'EVENT_TITLE' => 'string|nullable', 
			'EVENT_CONTENT' => 'string|nullable', 
			'EVENT_DATE_START' => 'string|nullable', 
			'EVENT_DATE_END' => 'string|nullable', 
			'EVENT_AUDIENCE' => 'string|nullable', 
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
        //return $request->all();
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

        try {
            
            $dataManageEvent = ManageEvent::find($request->MANAGE_EVENT_ID);
            //$dataManageEvent->MANAGE_ANNOUNCEMENT_ID = $request->DEPARTMENT;
            $dataManageEvent->EVENT_TITLE = $request->EVENT_TITLE;
            //$dataManageEvent->DEPARTMENT = $request->DEPARTMENT;
            $dataManageEvent->TS_ID = $request->TS_ID;
            $dataManageEvent->EVENT_CONTENT	 = $request->EVENT_CONTENT;
            $dataManageEvent->EVENT_DATE_START = $request->EVENT_DATE_START;
            $dataManageEvent->EVENT_DATE_END = $request->EVENT_DATE_END;
            $dataManageEvent->EVENT_DISTRIBUTOR_AUDIENCE = $request->EVENT_DISTRIBUTOR_AUDIENCE;
            $dataManageEvent->EVENT_CONSULTANT_AUDIENCE = $request->EVENT_CONSULTANT_AUDIENCE;
            $dataManageEvent->EVENT_OTHER_AUDIENCE = $request->EVENT_OTHER_AUDIENCE;
            //$dataManageEvent->CREATE_BY = $request->CREATE_BY;
            $dataManageEvent->PUBLISH_STATUS = $request->PUBLISH_STATUS;
            $dataManageEvent->save();

            // File Upload =======
            $file = $request->file;
            if($request->hasFile('file')){
                ManageEventDocument::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->delete();
                foreach ($file as $item){            
                    $itemFile = $item;
                    $blob = $item->openFile()->fread($itemFile->getSize());
                    $dataManageEventDoc = new ManageEventDocument;
                    $dataManageEventDoc->MANAGE_EVENT_ID = $dataManageEvent->MANAGE_EVENT_ID;
                    $dataManageEventDoc->DOCUMENT_BLOB = $blob;
                    $dataManageEventDoc->DOCUMENT_MIMETYPE = $itemFile->getMimeType();
                    $dataManageEventDoc->DOCUMENT_FILETYPE = $itemFile->getClientOriginalExtension();
                    $dataManageEventDoc->DOCUMENT_FILENAME = $itemFile->getClientOriginalName();
                    $dataManageEventDoc->DOCUMENT_FILESIZE = $itemFile->getSize();
                    $dataManageEventDoc->CREATE_BY = $request->CREATE_BY;
                    $dataManageEventDoc->save();
                }
            }
            $massage = "Data Successfully Update as draft !!";

            //approval data here=======
            if($request->PUBLISH_STATUS == "1"){
                foreach(json_decode($request->APPR_LIST) as $item) {   
                    //if($item->APPR_GROUP_ID == 2 && $item->APPROVAL_LEVEL_ID == 90){ 
                        $approval = new ManageEventApproval;
                        $approval->MANAGE_EVENT_ID = $dataManageEvent->MANAGE_EVENT_ID;
                        $approval->APPR_GROUP_ID = $item->APPR_GROUP_ID;
                        $approval->CREATE_BY = $request->CREATE_BY;
                        $approval->TS_ID = $request->TS_ID; 
                        $approval->APPROVAL_LEVEL_ID = $item->APPROVAL_LEVEL_ID;
                        $approval->APPR_PUBLISH_STATUS = $request->PUBLISH_STATUS;
                        $approval->APPR_STATUS = $request->PUBLISH_STATUS;
                        $approval->save();

                        // Notification
                        $notification = new ManageNotification();
                        $add = $notification->add(
                            $item->APPR_GROUP_ID,
                            $item->APPR_PROCESSFLOW_ID,
                            $request->NOTI_REMARK,
                            $request->NOTI_LOCATION
                        );
                    //}    
                    
                }
                $massage = "Data Successfully Published !!"; 
            }    
        
            http_response_code(200);
            return response([
                'message' =>  $massage
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }
    }

    public function delete(Request $request)
    {
        //return $request->MANAGE_EVENT_ID;
        try {
            $data_doc = ManageEventDocument::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->delete();
            $data = ManageEvent::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->delete();

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
			'MANAGE_ANNOUNCEMENT_ID' => 'integer|nullable', 
			'EVENT_TITLE' => 'string|nullable', 
			'EVENT_CONTENT' => 'string|nullable', 
			'EVENT_DATE_START' => 'string|nullable', 
			'EVENT_DATE_END' => 'string|nullable', 
			'EVENT_AUDIENCE' => 'string|nullable', 
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

    public function reviewAnnouncementUpdate(Request $request)
    {  
        
        // return response($request->all()); 
        // 1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:HOD SAVE AS DRAFT
        try {
            // Data Validation 
            $rules =[];
            if ($request->input('REMARK_CONTENT') == 'undefined') {
                $rules['REMARK_CONTENT'] = 'required|string';
            }
            if (!empty($rules)) {
                http_response_code(400);
                return response([
                    'message' => 'Please fill-up all required data !!.',
                    'errorCode' => 4106
                ],400);
            }
            //PUBLISH_STATUS : '1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN'
            $dataEvent = ManageEvent::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)->first();
            $dataEvent->TS_ID = $request->TS_ID;
            $dataEvent->CREATE_BY = $request->CREATE_BY;
            if($request->PUBLISH_STATUS == 2){
                $dataEvent->PUBLISH_STATUS = 2;
                $massage = "Data Successfully Approved !!";
            }elseif ($request->PUBLISH_STATUS == 4){
                $dataEvent->PUBLISH_STATUS = 4;
                $massage = "Data Successfully save as draft !!";
            }else{
                $dataEvent->PUBLISH_STATUS = 3;
                $massage = "Data Successfully Returned !!";
            }
            $dataEvent->save();

            // Update Event Approval table
            $updateAppr = ManageEventApproval::where('MANAGE_EVENT_ID',$request->MANAGE_EVENT_ID)
                        //->where('APPR_STATUS',1) 
                        ->first();           
            $updateAppr->APPR_REMARK = $request->REMARK_CONTENT;
            $updateAppr->TS_ID = $request->TS_ID;
            if($request->PUBLISH_STATUS == 2){
                $updateAppr->APPR_STATUS = 2;
                $updateAppr->APPR_PUBLISH_STATUS = 2;
            }elseif ($request->PUBLISH_STATUS == 4){
                $updateAppr->APPR_PUBLISH_STATUS = 4;
                $updateAppr->APPR_STATUS = 4;
            }else{
                $updateAppr->APPR_STATUS = 3;
                $updateAppr->APPR_PUBLISH_STATUS = 3;
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

    public function setAnnounceStatus(Request $request)
    { 
        //return $request->all();

        try {
            
            $result = DB::table('MANAGE_ANNOUNCEMENT')->updateOrInsert(
                ['MANAGE_DEPARTMENT_ID' =>  $request->DEPT_ID],
                [
                    'MANAGE_DEPARTMENT_ID' => $request->DEPT_ID,
                    'ANNOUNCEMENT_STATUS' => ($request->STATUS == 'true') ? 1 : 0,
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

    public function getAnnounceDepartment()
    {
        try {
            //$department = ManageDepartment::all();
            $department = DB::table('MANAGE_DEPARTMENT')
            ->select('*','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS MANAGE_DEPARTMENT_ID')
            ->leftJoin(
                'MANAGE_ANNOUNCEMENT', 
                'MANAGE_ANNOUNCEMENT.MANAGE_DEPARTMENT_ID',
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
    public function getAnnounceByDepartment(Request $request)
    {
        try {
            //$department = ManageDepartment::all();
            $department = DB::table('MANAGE_DEPARTMENT')
            ->select('*','MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS MANAGE_DEPARTMENT_ID')
            ->leftJoin(
                'MANAGE_ANNOUNCEMENT', 
                'MANAGE_ANNOUNCEMENT.MANAGE_DEPARTMENT_ID',
                'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID'
            )
            ->get();
            $data = ManageEvent::select('MANAGE_EVENT.EVENT_TITLE AS EVENT_TITLE','MANAGE_EVENT.MANAGE_EVENT_ID AS MANAGE_EVENT_ID','MANAGE_EVENT.DEPARTMENT AS DEPARTMENT')
            ->where('MANAGE_EVENT.DEPARTMENT', $request->USER_DEPARTMENT_ID)
            ->where('MANAGE_EVENT.PUBLISH_STATUS', 2)
            ->where('MANAGE_EVENT.TS_ID', 3)
            ->orderBy('MANAGE_EVENT.CREATE_TIMESTAMP', 'desc')
            ->take(5)
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
    public function getAllDepartment(Request $request)
    {
        //return $request->all();
        try {
            $data = ManageEvent::select('MANAGE_EVENT.MANAGE_EVENT_ID',DB::raw('substr(MANAGE_EVENT.EVENT_TITLE, 1,40) as EVENT_TITLE'),'MANAGE_EVENT.EVENT_CONTENT','MANAGE_EVENT.EVENT_DATE_START',
            'MANAGE_EVENT.EVENT_DATE_END', 'USER.USER_NAME','MANAGE_EVENT.CREATE_TIMESTAMP','STATUS.TS_ID',
            'MANAGE_EVENT.PUBLISH_STATUS','DEPT.DPMT_NAME','STATUS.TS_PARAM')
            //->leftJoin('MANAGE_ANNOUNCEMENT', 'MANAGE_ANNOUNCEMENT.MANAGE_ANNOUNCEMENT_ID', '=', 'MANAGE_EVENT.MANAGE_ANNOUNCEMENT_ID')
            ->leftJoin('USER', 'USER.USER_ID', '=', 'MANAGE_EVENT.CREATE_BY' )
            //->join('MANAGE_EVENT_DOCUMENT', 'MANAGE_EVENT_DOCUMENT.MANAGE_EVENT_ID', '=', 'MANAGE_EVENT.MANAGE_EVENT_ID')
            ->leftJoin('TASK_STATUS AS STATUS', 'STATUS.TS_ID', '=', 'MANAGE_EVENT.TS_ID')
            ->leftJoin('MANAGE_DEPARTMENT AS DEPT', 'DEPT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_EVENT.DEPARTMENT')
            
            //->orderBy('MANAGE_EVENT.CREATE_TIMESTAMP', 'desc')
            ->where('MANAGE_EVENT.PUBLISH_STATUS',2)
            ->where('MANAGE_EVENT.TS_ID', 3)
            ->where('MANAGE_EVENT.DEPARTMENT', $request->DEPARTMENT)
            ->get();

            foreach($data as $item){
                $item->EVENT_DATE_START = date('d-m-Y', strtotime($item->EVENT_DATE_START));
                $item->EVENT_DATE_END = date('d-m-Y', strtotime($item->EVENT_DATE_END));
                $item->CREATE_TIMESTAMP = date('d-m-Y', strtotime($item->CREATE_TIMESTAMP));
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\PageMaintenance;
use App\Models\ManageModule;
use App\Models\DistributorManageModule;
use App\Models\SettingGeneral;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PageMaintenanceController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = PageMaintenance::select('*')
                ->leftJoin('SETTING_GENERAL', 'SETTING_GENERAL.SET_CODE', '=', 'PAGE_MAINTENANCE.AUDIENCE')
                ->where('SETTING_GENERAL.SET_TYPE', '=', 'AUDIENCE')
                ->find($request->PAGE_MAINTENANCE_ID);

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
            ], 400);
        }
    }
    public function getdetail(Request $request)
    {
        try {
            $data = PageMaintenance::select('*')
                ->leftJoin('SETTING_GENERAL', 'SETTING_GENERAL.SET_CODE', '=', 'PAGE_MAINTENANCE.AUDIENCE')
                ->where('SETTING_GENERAL.SET_TYPE', '=', 'AUDIENCE')
                ->find($request->PAGE_MAINTENANCE_ID);
            $str = json_decode($data->MAINTENANCE_MODULE, true);
            $modename = array();
            if ($data->AUDIENCE == 1) {
                $datamodule = ManageModule::select('MANAGE_MODULE.MOD_NAME AS MOD_NAME')
                    ->whereIN('MANAGE_MODULE.MANAGE_MODULE_ID', $str)
                    ->get();
                foreach ($datamodule as $element1) {
                    array_push($modename, $element1->MOD_NAME);
                }
            }
            if ($data->AUDIENCE == 2) {
                $datamodule = DistributorManageModule::select('DISTRIBUTOR_MANAGE_MODULE.DISTRIBUTOR_MOD_NAME AS MOD_NAME')
                    ->whereIN('DISTRIBUTOR_MANAGE_MODULE.DISTRIBUTOR_MANAGE_MODULE_ID', $str)
                    ->get();
                foreach ($datamodule as $element1) {
                    array_push($modename, $element1->MOD_NAME);
                }
            } else {
                array_push($modename, 0);
            }
            $data->MAINTENANCE_MODULE = $modename;
            $data->MAINTENANCE_END_DATE = date('d-M-Y', strtotime($data->MAINTENANCE_END_DATE));
            $data->MAINTENANCE_START_DATE = date('d-M-Y', strtotime($data->MAINTENANCE_START_DATE));

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
            ], 400);
        }
    }
    public function getAudience(Request $request)
    {
        try {
            $data = DB::table('SETTING_GENERAL')
                ->select('*')
                ->where('SET_TYPE', 'AUDIENCE')
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
            ], 400);
        }
    }

    public function getAll(Request $request)
    {

        try {
            $data = PageMaintenance::select('*', 'PAGE_MAINTENANCE.MAINTENANCE_START_DATE AS START_DATE', 'PAGE_MAINTENANCE.MAINTENANCE_END_DATE AS END_DATE', 'PAGE_MAINTENANCE.MAINTENANCE_MODULE AS MAINTENANCE_MODULE')
                ->JOIN('SETTING_GENERAL', 'SETTING_GENERAL.SET_CODE', '=', 'PAGE_MAINTENANCE.AUDIENCE')
                ->where('SETTING_GENERAL.SET_TYPE', '=', 'AUDIENCE')
                ->leftJoin('USER', 'USER.USER_ID', '=', 'PAGE_MAINTENANCE.CREATION_BY')
                ->get();
            $modename = array();
            foreach ($data as $element) {
                $str = json_decode($element->MAINTENANCE_MODULE, true);
                //  $arr = substr($element->MAINTENANCE_MODULE, 1, -1);
                // $str = json_decode($element->MAINTENANCE_MODULE);

                // $arr = explode('"',$arr);
                // Log::info("log1=",$str);
                // $modename = array();
                // $datamodule = ManageModule::select('MANAGE_MODULE.MOD_NAME AS MOD_NAME')
                //  ->whereIN('MANAGE_MODULE.MANAGE_MODULE_ID',$str)
                //  ->get();
                //  foreach($datamodule as $element1){
                //     array_push($modename,$element1->MOD_NAME);
                //  }
                // $arr = substr($modename, 1, -1);
                $element->START_DATE = date('d-M-Y', strtotime($element->MAINTENANCE_START_DATE));
                $element->END_DATE = date('d-M-Y', strtotime($element->MAINTENANCE_END_DATE));
                // $element->MAINTENANCE_MODULE = $modename;
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
            ], 400);
        }
    }

    public function create(Request $request)
    {
        //return $request->all();
        // Server validation

        $rules = [];
        if ($request->input('MAINTENANCE_START_DATE') == "Invalid date") {
            $rules['MAINTENANCE_START_DATE'] = 'required|string';
        }
        if ($request->input('MAINTENANCE_END_DATE') == "Invalid date") {
            $rules['MAINTENANCE_END_DATE'] = 'required|string';
        }
        if ($request->input('NOTIFICATION_DESC') == NULL) {
            $rules['NOTIFICATION_DESC'] = 'required|string';
        }
        if ($request->input('NOTIFICATION_TITLE') == NULL) {
            $rules['NOTIFICATION_TITLE'] = 'required|string';
        }
        if ($request->input('AUDIENCE') == 'undefined') {
            $rules['AUDIENCE'] = 'required|string';
        }
        if ($request->input('MAINTENANCE_MODULE') == '[]') {
            $rules['MAINTENANCE_MODULE'] = 'required|string';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            $data = new PageMaintenance;
            $data->MAINTENANCE_START_DATE = $request->MAINTENANCE_START_DATE;
            $data->MAINTENANCE_END_DATE = $request->MAINTENANCE_END_DATE;
            $data->NOTIFICATION_DESC = strtoupper($request->NOTIFICATION_DESC);
            $data->NOTIFICATION_TITLE = strtoupper($request->NOTIFICATION_TITLE);
            $data->AUDIENCE = $request->AUDIENCE;
            $data->MAINTENANCE_MODULE = $request->MAINTENANCE_MODULE;
            $data->CREATION_BY = $request->CREATION_BY;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ], 400);
        }
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MAINTENANCE_START_DATE' => 'required|integer',
            'MAINTENANCE_END_DATE' => 'required|integer',
            'NOTIFICATION_DESC' => 'required|string',
            'AUDIENCE' => 'required|integer',
            'MAINTENANCE_MODULE' => 'required|string',
            'CREATION_BY' => 'required|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
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
            ], 400);
        }
    }

    public function update(Request $request)
    {
        //return $request->all();
        // Server validation
        $rules = [];
        if ($request->input('MAINTENANCE_START_DATE') == "Invalid date") {
            $rules['MAINTENANCE_START_DATE'] = 'required|string';
        }
        if ($request->input('MAINTENANCE_END_DATE') == "Invalid date") {
            $rules['MAINTENANCE_END_DATE'] = 'required|string';
        }
        if ($request->input('NOTIFICATION_TITLE') == NULL) {
            $rules['NOTIFICATION_TITLE'] = 'required|string';
        }
        if ($request->input('NOTIFICATION_DESC') == NULL) {
            $rules['NOTIFICATION_DESC'] = 'required|string';
        }
        if ($request->input('AUDIENCE') == 'undefined') {
            $rules['AUDIENCE'] = 'required|string';
        }
        if ($request->input('MAINTENANCE_MODULE') == '[]') {
            $rules['MAINTENANCE_MODULE'] = 'required|string';
        }
        if (!empty($rules)) {
            http_response_code(400);
            return response([
                'message' => 'Please fill-up all required data !!.',
                'errorCode' => 4106
            ], 400);
        }


        try {
            $data = PageMaintenance::find($request->PAGE_MAINTENANCE_ID);
            $data->MAINTENANCE_START_DATE = $request->MAINTENANCE_START_DATE;
            $data->MAINTENANCE_END_DATE = $request->MAINTENANCE_END_DATE;
            $data->NOTIFICATION_DESC = strtoupper($request->NOTIFICATION_DESC);
            $data->NOTIFICATION_TITLE = strtoupper($request->NOTIFICATION_TITLE);
            $data->AUDIENCE = $request->AUDIENCE;
            $data->MAINTENANCE_MODULE = $request->MAINTENANCE_MODULE;
            $data->CREATION_BY = $request->CREATION_BY;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = PageMaintenance::find($request->PAGE_MAINTENANCE_ID);
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
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        //return $request->all();

        try {
            $data = PageMaintenance::select('*', 'PAGE_MAINTENANCE.MAINTENANCE_START_DATE AS START_DATE', 'PAGE_MAINTENANCE.MAINTENANCE_END_DATE AS END_DATE')
                ->leftJoin('USER', 'USER.USER_ID', '=', 'PAGE_MAINTENANCE.CREATION_BY')
                ->leftJoin('SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'PAGE_MAINTENANCE.AUDIENCE');
            if ($request->AUDIENCE) {
                $data->where('PAGE_MAINTENANCE.AUDIENCE', $request->AUDIENCE);
            }
            if ($request->VARIETION) {
                $data->where('PAGE_MAINTENANCE.MAINTENANCE_MODULE', 'like', '%' . $request->VARIETION . '%');
            }
            $data = $data->get();

            foreach ($data as $element) {
                $element->START_DATE = date('d-M-Y', strtotime($element->MAINTENANCE_START_DATE));
                $element->END_DATE = date('d-M-Y', strtotime($element->MAINTENANCE_END_DATE));
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
            ], 400);
        }
    }
    public function getMaintanceNotificationlist(Request $request)
    {
        try {
            $audienceid = 0;
            if ($request->USER_TYPE == 'fimm') {
                $audienceid = 1;
            }
            if ($request->USER_TYPE == 'DISTRIBUTOR') {
                $audienceid = 2;
            }
            // if($request->USER_TYPE == 'CONSULTANT')
            // {
            //     $audienceid = 3;
            // }
            // if($request->USER_TYPE == 'ESC')
            // {
            //     $audienceid = 5;
            // }
            // if($request->USER_TYPE == 'OTHERS')
            // {
            //     $audienceid = 4;
            // }
            if ($request->USER_TYPE == 'fimm') {
                $data = ManageModule::where('MANAGE_MODULE.MOD_NAME', 'like', '%' . $request->menutitle . '%')->first();
                $dataid = $data->MANAGE_MODULE_ID;
            }
            if ($request->USER_TYPE == 'DISTRIBUTOR') {
                $data = DistributorManageModule::where('DISTRIBUTOR_MANAGE_MODULE.DISTRIBUTOR_MOD_NAME', 'like', '%' . $request->menutitle . '%')->first();
                $dataid = $data->DISTRIBUTOR_MANAGE_MODULE_ID;
            }

            if ($data) {

                $currentdate = Carbon::now()->format('Y-m-d');
                $datapage = PageMaintenance::select('*')
                    ->where('PAGE_MAINTENANCE.AUDIENCE', '=', $audienceid)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_START_DATE', '>=', $currentdate)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_END_DATE', '<=', $currentdate)
                    ->whereRaw('"' . $currentdate . '" between `MAINTENANCE_START_DATE` and `MAINTENANCE_END_DATE`')
                    //->whereRaw('"'.$data->MANAGE_MODULE_ID.'" in `MAINTENANCE_MODULE`')
                    ->get();
                $databyid = array();
                $dt = array();
                if ($datapage) {
                    foreach ($datapage as $element) {
                        $screenIdArray = json_decode($element->MAINTENANCE_MODULE, true);
                        if (in_array($dataid, $screenIdArray)) {
                            // Log::info("log=".$data->MANAGE_MODULE_ID);
                            $dt['MAINTENANCE_START_DATE'] = date('d-M-Y', strtotime($element->MAINTENANCE_START_DATE));
                            $dt['MAINTENANCE_END_DATE'] =  date('d-M-Y', strtotime($element->MAINTENANCE_END_DATE));
                            $dt['AUDIENCE'] =  $element->AUDIENCE;
                            $dt['NOTIFICATION_TITLE'] =  $element->NOTIFICATION_TITLE;
                            $dt['NOTIFICATION_DESC'] =  $element->NOTIFICATION_DESC;
                            array_push($databyid, $dt);
                        } else {
                        }
                    }
                    http_response_code(200);
                    return response([
                        'message' => 'Data successfully retrieved.',
                        'data' => $databyid
                    ]);
                }
                // else{
                //     http_response_code(400);
                //     return response([
                //         'message' => 'No',
                //         'errorCode' => 4103
                //     ],400);
                // }
            } else {
                http_response_code(400);
                return response([
                    'message' => 'No',
                    'errorCode' => 4103
                ], 400);
            }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }
    public function getMaintanceNotificationlistByType(Request $request)
    {
        try {

            $audienceid = 0;
            if ($request->USER_TYPE == 'fimm') {
                $audienceid = 1;
            }
            if ($request->USER_TYPE == 'DISTRIBUTOR') {
                $audienceid = 2;
            }
            if ($request->USER_TYPE == 'CONSULTANT') {
                $audienceid = 3;
            }
            if ($request->USER_TYPE == 'TRAININGPROVIDER') {
                $audienceid = 4;
            }
            if ($request->USER_TYPE == 'THIRDPARTY') {
                $audienceid = 5;
            }
            if ($request->USER_TYPE == 'ESC') {
                $audienceid = 6;
            }
            if ($request->USER_TYPE == 'MEDIA') {
                $audienceid = 7;
            }

            if ($audienceid != 0) {
                $currentdate = Carbon::now()->format('Y-m-d');

                $datapage = PageMaintenance::select('*')
                    ->where('PAGE_MAINTENANCE.AUDIENCE', '=', $audienceid)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_START_DATE', '>=', $currentdate)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_END_DATE', '<=', $currentdate)
                    ->whereRaw('"' . $currentdate . '" between `MAINTENANCE_START_DATE` and `MAINTENANCE_END_DATE`')
                    //->whereRaw('"'.$data->MANAGE_MODULE_ID.'" in `MAINTENANCE_MODULE`')
                    ->orderBy(DB::raw('PAGE_MAINTENANCE.MAINTENANCE_START_DATE'), 'desc')
                    ->get();
                $databyid = array();
                $dt = array();
                if ($datapage) {
                    foreach ($datapage as $element) {
                        // $screenIdArray = json_decode($element->MAINTENANCE_MODULE,true);
                        // if(in_array($data->MANAGE_MODULE_ID, $screenIdArray)){
                        // Log::info("log=".$data->MANAGE_MODULE_ID);
                        $dt['MAINTENANCE_START_DATE'] = date('d-M-Y', strtotime($element->MAINTENANCE_START_DATE));
                        $dt['MAINTENANCE_END_DATE'] =  date('d-M-Y', strtotime($element->MAINTENANCE_END_DATE));
                        $dt['AUDIENCE'] =  $element->AUDIENCE;
                        $dt['NOTIFICATION_TITLE'] =  $element->NOTIFICATION_TITLE;
                        $dt['NOTIFICATION_DESC'] =  $element->NOTIFICATION_DESC;
                        array_push($databyid, $dt);
                        // /
                    }
                    http_response_code(200);
                    return response([
                        'message' => 'Data successfully retrieved.',
                        'data' => $databyid
                    ]);
                }
            }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }
    public function getMaintanceNotificationlistByTypeOthers(Request $request)
    {
        try {

            $audienceid = 0;
            if ($request->USER_TYPE == 'fimm') {
                $audienceid = 1;
            }
            if ($request->USER_TYPE == 'DISTRIBUTOR') {
                $audienceid = 2;
            }
            if ($request->USER_TYPE == 'CONSULTANT') {
                $audienceid = 3;
            }
            if ($request->USER_TYPE == 'TRAININGPROVIDER') {
                $audienceid = 4;
            }
            if ($request->USER_TYPE == 'THIRDPARTY') {
                $audienceid = 5;
            }
            if ($request->USER_TYPE == 'ESC') {
                $audienceid = 6;
            }
            if ($request->USER_TYPE == 'MEDIA') {
                $audienceid = 7;
            }

            if ($audienceid != 0) {
                $currentdate = Carbon::now()->format('Y-m-d');

                $datapage = PageMaintenance::select('*')
                    ->where('PAGE_MAINTENANCE.AUDIENCE', '=', $audienceid)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_START_DATE', '>=', $currentdate)
                    // ->whereDate('PAGE_MAINTENANCE.MAINTENANCE_END_DATE', '<=', $currentdate)
                    ->whereRaw('"' . $currentdate . '" between `MAINTENANCE_START_DATE` and `MAINTENANCE_END_DATE`')
                    //->whereRaw('"'.$data->MANAGE_MODULE_ID.'" in `MAINTENANCE_MODULE`')
                    ->orderBy(DB::raw('PAGE_MAINTENANCE.MAINTENANCE_START_DATE'), 'desc')
                    ->get();
                $databyid = array();
                $dt = array();
                if ($datapage) {
                    foreach ($datapage as $element) {
                        // $screenIdArray = json_decode($element->MAINTENANCE_MODULE,true);
                        // if(in_array($data->MANAGE_MODULE_ID, $screenIdArray)){
                        // Log::info("log=".$data->MANAGE_MODULE_ID);
                        $dt['MAINTENANCE_START_DATE'] = date('d-M-Y', strtotime($element->MAINTENANCE_START_DATE));
                        $dt['MAINTENANCE_END_DATE'] =  date('d-M-Y', strtotime($element->MAINTENANCE_END_DATE));
                        $dt['AUDIENCE'] =  $element->AUDIENCE;
                        $dt['NOTIFICATION_TITLE'] =  $element->NOTIFICATION_TITLE;
                        $dt['NOTIFICATION_DESC'] =  $element->NOTIFICATION_DESC;
                        array_push($databyid, $dt);
                        // /
                    }
                    http_response_code(200);
                    return response([
                        'message' => 'Data successfully retrieved.',
                        'data' => $databyid
                    ]);
                }
            }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DashboardConsultantDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardConsultantDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            $data_consultant = DashboardConsultantDisplaySetting::where('ACCESS_USER_DIVISION',$request->ACCESS_USER_DIVISION)
             ->where('ACCESS_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
             ->where('ACCESS_USER_GROUP',$request->SETTING_USER_GROUP)
           // ->orWhere('SUPER_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->first();
            if($data_consultant){
               // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_CONSULTANT_DISPLAY_SETTING AS DASHBOARD_CONSULTANT_DISPLAY_SETTING')
                ->select('DASHBOARD_CONSULTANT_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_CONSULTANT_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_CONSULTANT_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
                ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
               // ->orWhere('DASHBOARD_CONSULTANT_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
               // ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
               // ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
                ->orderBy('DASHBOARD_CONSULTANT_DISPLAY_SETTING.SETTING_INDEX', 'asc')
                ->get();
                Log::info($data);
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
                ]);
          }
          else{
            http_response_code(400);
            return response([
            'message' => 'Data Not Found.',
            'errorCode' => 4103
            ]);
          }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getChartSettingOne(Request $request)
    {
        try{
            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');
            // Log::info("month=".$currentMonth);
            // Log::info("day=".$currentday);
            $single_registration = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'))
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT_LICENSE.CONSULTANT_ID')
            ->having('c', '=' , 1)
            ->where('CONSULTANT_RESULT.CONSULTANT_RESULT','=',34)
            ->where(DB::raw('YEAR(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            //->orderBy(DB::raw('TRANSACTION_LEDGER.CREATE_TIMESTAMP'), 'desc')
            ->count();

            $dual_registration_same = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID','CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'),DB::raw('count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1'))
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT_LICENSE.CONSULTANT_ID')
            ->having('c', '=' , 2)
            ->having('c1', '=' , 2)
            ->where('CONSULTANT_RESULT.CONSULTANT_RESULT','=',34)
            ->where(DB::raw('YEAR(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->count();
            $dual_registration_diff = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID','CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'),DB::raw('count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1'))
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT_LICENSE.CONSULTANT_ID')
            ->having('c', '=' , 2)
            ->having('c1', '=' , 1)
            ->where('CONSULTANT_RESULT.CONSULTANT_RESULT','=',34)
            ->where(DB::raw('YEAR(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID','CONSULTANT_LICENSE.DISTRIBUTOR_ID')
            ->count();

            $data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID','CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'),DB::raw('count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1'))
            ->having('c', '=' , 2)
           // ->having('c1', '!=' , 2)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->get();

           // Log::info(print_r($data));
            $d = new \stdClass();
            $d->single_registration = $single_registration;
            $d->dual_registration_same = $dual_registration_same;
            $d->dual_registration_diff = $dual_registration_diff;
            http_response_code(200);
            return response([
            'message' => 'Data successfully retrieved.',
            'data' => $d,
            ]);

        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getChartSettingFour(Request $request)
    {
        try{

            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');
            // Log::info("month=".$currentMonth);
            // Log::info("day=".$currentday);
            $single_registration_utc = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'))
            ->having('c', '=' , 1)
            ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',1)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->count();
            $single_registration_prc = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'))
            ->having('c', '=' , 1)
            ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',2)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->count();
            $dual_registration_same = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'),DB::raw('count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1'))
            ->having('c', '=' , 2)
            ->having('c', '=' , 2)
           // ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',2)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->count();
            $dual_registration_diff = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'),DB::raw('count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1'))
            ->having('c', '=' , 2)
            ->having('c', '=' , 1)
           // ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',2)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            ->count();
            //  Log::info(print_r($single_registration_utc));

            $d = new \stdClass();
            $d->single_registration_utc = $single_registration_utc;
            $d->single_registration_prc = $single_registration_prc;
            $d->dual_registration_same = $dual_registration_same;
            $d->dual_registration_diff = $dual_registration_diff;
            http_response_code(200);
            return response([
            'message' => 'Data successfully retrieved.',
            'data' => $d,
            ]);

        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getChartSettingFive(Request $request)
    {
        try{

            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');

            $active_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',295)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();

            $termination_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->whereIN('CONSULTANT_LICENSE.CONSULTANT_STATUS', [296,297,298,299,300,301,302,303])
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
            $resignation_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',304)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
            $revocation_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',799)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
           // Log::info(print_r($approve_data));
            $d = new \stdClass();
            $d->active_data = $active_data;
            $d->termination_data = $termination_data;
            $d->resignation_data = $resignation_data;
            $d->revocation_data = $revocation_data;
            http_response_code(200);
            return response([
            'message' => 'Data successfully retrieved.',
            'data' => $d,
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

        $req = $request->params;
        $user_id=$request->userid;
        $user_type=$request->usertype;
        $user_group=$request->usergroup;
        $access_user_division = $request->ACCESS_USER_DIVISION;
        $access_user_departrment = $request->ACCESS_USER_DEPARTMENT;
        $super_user_department = 7;
        $access_user_group = $request->ACCESS_USER_GROUP;
       // $access_user_role = $request->ACCESS_USER_ROLE;
       // $accountinfo = $request['accountInfo'];
      // Log::info("Request=". $request );
       // Log::info( $req );

        //  $validator = Validator::make($request->all(), [
        //         'DASHBOARD_SETTING_ID' => 'required ',
        //         'SETTING_CHART_ID' => 'required',
        //         'SETTING_INDEX' => 'required',
        //        // 'SETTING_USER_ID' => 'required',
        //         'SETTING_STATUS' => 'required',
        //         'DISPLAY_SETTING_STYLE' => 'required',
        //     ]);

        //     if ($validator->fails()) {
        //         http_response_code(400);
        //         return response([
        //             'message' => 'Data validation error.',
        //             'errorCode' => 4106
        //         ],400);
        //     }

            try {
                //create function
              //  $user_id=$request->header('Uid');
                foreach ($req as $r) {
                   // Log::info( print_r($r,true) );
                   // Log::info( $r['setting_setup']['DISPLAY_SETTING_ID'],true) );
                        if(isset($r['setting_setup']['DISPLAY_SETTING_ID']))
                        {
                            $data =DashboardConsultantDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardConsultantDisplaySetting;
                        }
                            $data->DASHBOARD_SETTING_ID = $r['DASHBOARD_MAIN_ID'];
                            $data->SETTING_USER_ID = $user_id;
                            $data->SETTING_USER_TYPE = $user_type;
                            $data->SETTING_USER_GROUP = $user_group;
                            $data->SETTING_CHART_ID = $r['setting_setup']['SETTING_CHART_ID'];
                            $data->SETTING_INDEX = $r['setting_setup']['SETTING_INDEX'];
                            $data->SETTING_STATUS = $r['setting_setup']['SETTING_STATUS'];
                            $data->DISPLAY_SETTING_STYLE = 'Yearly';
                            $data->ACCESS_USER_DIVISION = $access_user_division;
                            $data->ACCESS_USER_DEPARTMENT = $access_user_departrment;
                            $data->SUPER_USER_DEPARTMENT = $super_user_department;
                            $data->ACCESS_USER_GROUP = $access_user_group;
                           // $data->ACCESS_USER_ROLE = $access_user_role;
                            $data->save();
                }

                //  foreach(json_decode($request->COUNTRY_LIST) as $element){
                //     $bulkupload = new SettingGeneral;
                //     $bulkupload->SET_PARAM = $element->SET_PARAM;
                //     $bulkupload->SET_TYPE = $element->SET_TYPE;
                //     $bulkupload->SET_VALUE = $element->SET_VALUE;
                //     $bulkupload->save();
                //    }

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.',
                    'data' => $data
                    // 'bulkUpload' => $bulkupload
                ]);

            } catch (RequestException $r) {

                http_response_code(400);
                return response([
                    'message' => 'Data failed to be updated.',
                    'errorCode' => 4100
                ],400);
            }

        }
        public function delete(Request $request)
        {
            Log::info( "POST ID ===>" . $request);
            try {
            $data = DashboardConsultantDisplaySetting::find($request->DISPLAY_SETTING_ID);
            $data->delete();


            http_response_code(200);
            return response([
            'message' => 'Data successfully deleted',
            ]);
            } catch (\Throwable $th) {
            http_response_code(400);
            return response([
            'message' => 'Failed to delete data',
            'errorCode' =>  $th
            ]);
            }
        }
}

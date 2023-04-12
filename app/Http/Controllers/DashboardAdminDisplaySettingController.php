<?php

namespace App\Http\Controllers;

use App\Models\DashboardAdminDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardAdminDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

           // $data_admin = DashboardAdminDisplaySetting::where('SETTING_USER_ID',$request->SETTING_USER_ID)->where('SETTING_USER_TYPE',$request->SETTING_USER_TYPE)->first();
            $data_admin = DashboardAdminDisplaySetting::where('ACCESS_USER_DEPARTMENT','=',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_DIVISION','=',$request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_GROUP','=',$request->ACCESS_USER_GROUP)
            //->orWhere('SUPER_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->first();
            if($data_admin){
                //Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_ADMIN_DISPLAY_SETTING AS DASHBOARD_ADMIN_DISPLAY_SETTING')
                ->select('DASHBOARD_ADMIN_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_ADMIN_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_ADMIN_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
                ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
              //  ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
            //    ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            //    ->orWhere('DASHBOARD_ADMIN_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->orderBy('DASHBOARD_ADMIN_DISPLAY_SETTING.SETTING_INDEX', 'asc')
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
    public function getAdminChartSettingOne(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Online User
                $data_fimm = DB::table('admin_management.USER AS USER')->where('USER.ISLOGIN','=',1)->count();
                $data_consulttant = DB::table('consultant_management.USER AS USER')->where('USER.ISLOGIN','=',1)->count();
                $data_distributor = DB::table('distributor_management.USER AS USER')->where('USER.ISLOGIN','=',1)->count();
                $data_other = DB::table('funds_management.TP_USER  AS TP_USER ')->where('TP_USER .ISLOGIN','=',1)->count();

                $data_fimm_register = DB::table('admin_management.USER AS USER')
                                        ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER.CREATE_TIMESTAMP) as MONTH'))
                                        ->groupBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'))
                                        ->groupBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'))
                                        ->orderBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'), 'asc')
                                        ->orderBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'), 'desc')
                                         ->get();
                $data_distributor_register = DB::table('distributor_management.USER AS USER')
                                        ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER.CREATE_TIMESTAMP) as MONTH'))
                                        ->groupBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'))
                                        ->groupBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'))
                                        ->orderBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'), 'asc')
                                        ->orderBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'), 'desc')
                                         ->get();
                $data_consultant_register = DB::table('consultant_management.USER AS USER')
                                         ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER.CREATE_TIMESTAMP) as MONTH'))
                                         ->groupBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'))
                                         ->groupBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'))
                                         ->orderBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'), 'asc')
                                         ->orderBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'), 'desc')
                                          ->get();
                $data_other_register = DB::table('funds_management.TP_USER AS USER')
                                         ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER.CREATE_TIMESTAMP) as MONTH'))
                                         ->groupBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'))
                                         ->groupBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'))
                                         ->orderBy(DB::raw('MONTH(USER.CREATE_TIMESTAMP)'), 'asc')
                                         ->orderBy(DB::raw('YEAR(USER.CREATE_TIMESTAMP)'), 'desc')
                                          ->get();
                $data_total_online_fimm = DB::table('admin_management.USER_LOGIN_LOG AS USER_LOGIN_LOG')
                                         ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP) as MONTH'),'USER_LOGIN_LOG.USER_TYPE AS USER_TYPE')
                                         ->where('USER_LOGIN_LOG.USER_TYPE','=',1)
                                         ->groupBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                         ->groupBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                        // ->groupBy('USER_LOGIN_LOG.USER_TYPE')
                                         ->orderBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'asc')
                                         ->orderBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'desc')
                                          ->get();
                 $data_total_online_dist = DB::table('admin_management.USER_LOGIN_LOG AS USER_LOGIN_LOG')
                                          ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP) as MONTH'),'USER_LOGIN_LOG.USER_TYPE AS USER_TYPE')
                                          ->where('USER_LOGIN_LOG.USER_TYPE','=',2)
                                          ->groupBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                          ->groupBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                         // ->groupBy('USER_LOGIN_LOG.USER_TYPE')
                                          ->orderBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'asc')
                                          ->orderBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'desc')
                                           ->get();
                $data_total_online_con = DB::table('admin_management.USER_LOGIN_LOG AS USER_LOGIN_LOG')
                                           ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP) as MONTH'),'USER_LOGIN_LOG.USER_TYPE AS USER_TYPE')
                                           ->where('USER_LOGIN_LOG.USER_TYPE','=',3)
                                           ->groupBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                           ->groupBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                          // ->groupBy('USER_LOGIN_LOG.USER_TYPE')
                                           ->orderBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'asc')
                                           ->orderBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'desc')
                                            ->get();
                $data_total_online_other = DB::table('admin_management.USER_LOGIN_LOG AS USER_LOGIN_LOG')
                                           ->select(DB::raw('count(*) as total'),DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP) as MONTH'),'USER_LOGIN_LOG.USER_TYPE AS USER_TYPE')
                                           ->where('USER_LOGIN_LOG.USER_TYPE','=',4)
                                           ->groupBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                           ->groupBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'))
                                          // ->groupBy('USER_LOGIN_LOG.USER_TYPE')
                                           ->orderBy(DB::raw('MONTH(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'asc')
                                           ->orderBy(DB::raw('YEAR(USER_LOGIN_LOG.CREATE_TIMESTAMP)'), 'desc')
                                            ->get();



               // $data = count($data);
                //Log::info(print_r($data_total_online_fimm));
               $d = new \stdClass();
               $d->fimm_online = $data_fimm;
               $d->consultant_online = $data_consulttant;
               $d->distributor_online = $data_distributor;
               $d->other_online = $data_other;
               $d->fimm_register = $data_fimm_register;
               $d->dist_register = $data_distributor_register;
               $d->consultant_register = $data_consultant_register;
               $d->other_register = $data_other_register;
               $d->total_online_fimm = $data_total_online_fimm;
               $d->total_online_dist = $data_total_online_dist;
               $d->total_online_con = $data_total_online_con;
               $d->total_online_other = $data_total_online_other;
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
    public function getAdminChartSettingTwo(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Post Vetting Data
                $query = DB::table('admin_management.SYSTEM_INFORMATION_ADMIN AS SYSTEM_INFORMATION_ADMIN')->get();
               // Pre Vetting Data


               // $data = count($data);
               // Log::info(print_r($query));
            //    $d = new \stdClass();
            //    $d->post_data = $data;
            //    $d->pre_data = $data1;
            //    $d->module_data = $data2;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $query,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getChartSettingThree(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            $query = DB::table('consultant_management.CONSULTANT AS CONSULTANT')
                 ->select(DB::raw('IFNULL(count(*),0) as total'),'SETTING_GENERAL.SET_CODE as SET_CODE','SETTING_GENERAL.SETTING_GENERAL_ID as SETTING_GENERAL_ID')
                 ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

               $data = $query
               ->whereIN('SETTING_GENERAL.SETTING_GENERAL_ID' , [263,264,265,266,267,268,269])
               //->whereIN(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), [$previousYear, $previousYear1,$previousYear2,$previousYear3,$previousYear4])
               //->groupBy(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'))
               ->groupBy('SETTING_GENERAL.SET_CODE')
              // ->groupBy(DB::Raw('IFNULL(CONSULTANT.CONSULTANT_STATUS, 0 )'))
               //->orderBy(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), 'desc')
               ->orderBy(DB::raw('SETTING_GENERAL.SETTING_GENERAL_ID'), 'asc')
               ->get();
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getAdminChartSettingFour(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
             // Renewal Date
                $query = DB::table('admin_management.CONSULTANT_RENEWAL_DATE AS CONSULTANT_RENEWAL_DATE')->orderBy('CONSULTANT_RENEWAL_DATE_ID','desc')->first();

               $currentDate =  Carbon::now()->format('Y-m-d');
               $currentDateTime= strtotime($currentDate);
               $con_renewal_start_date = $query->CONSULTANT_RENEWAL_START_DATE;
               $con_renewal_start_date_time= strtotime($con_renewal_start_date);
               $con_renewal_end_date = $query->CONSULTANT_RENEWAL_END_DATE;
               $con_renewal_end_date_time= strtotime($con_renewal_end_date);
               $datediff =  $con_renewal_start_date_time - $currentDateTime ;
               $datediffend =  $con_renewal_end_date_time - $currentDateTime ;
               $diff = round($datediff / (60 * 60 * 24));
               $diffend = round($datediffend / (60 * 60 * 24));
               if($diff < 0)
               {
                   $start_count = 0;
               }
               else{
                $start_count = $diff;
               }
               if($diffend < 0)
               {
                   $end_count = 0;
               }
               else{
                $end_count = $diffend;
               }
               $renewal_start = date('d/m/Y', strtotime($query->CONSULTANT_RENEWAL_START_DATE));
               $renewal_end = date('d/m/Y', strtotime($query->CONSULTANT_RENEWAL_END_DATE));
               // Annual Fee
               $queryannual = DB::table('admin_management.ANNUAL_FEES_DATE AS ANNUAL_FEES_DATE')
                              ->orderBy('ANNUAL_FEES_DATE_ID','desc')->first();

               $annual_fee_start_date = $queryannual->ASSESSMENT_START_DATE;
               $annual_fee_start_date_time= strtotime($annual_fee_start_date);
               $annual_fee_end_date = $queryannual->ASSESSMENT_END_DATE;
               $annual_fee_end_date_time= strtotime($annual_fee_end_date);
               $datediffannualstart =  $annual_fee_start_date_time - $currentDateTime ;
               $datediffannualend =  $annual_fee_end_date_time - $currentDateTime ;
               $diffannualstart = round($datediffannualstart / (60 * 60 * 24));
               $diffannualend = round($datediffannualend / (60 * 60 * 24));
               if($diffannualstart < 0)
               {
                   $annual_start_count = 0;
               }
               else{
                $annual_start_count = $diffannualstart;
               }
               if($diffannualend < 0)
               {
                   $annual_end_count = 0;
               }
               else{
                $annual_end_count = $diffannualend;
               }
               $annual_fee_start = date('d/m/Y', strtotime($queryannual->ASSESSMENT_START_DATE));
               $annual_fee_end = date('d/m/Y', strtotime($queryannual->ASSESSMENT_END_DATE));

               // Schedule Preventive Maintenance
               $queryschedule = DB::table('admin_management.PAGE_MAINTENANCE AS PAGE_MAINTENANCE')
                              ->orderBy('PAGE_MAINTENANCE_ID','desc')->first();

               $schedule_start_date = $queryschedule->MAINTENANCE_START_DATE;
               $schedule_start_date_time= strtotime($schedule_start_date);
               $schedule_end_date = $queryschedule->MAINTENANCE_END_DATE;
               $schedule_end_date_time= strtotime($schedule_end_date);
               $datediffschedulestart =  $schedule_start_date_time - $currentDateTime ;
               $datediffscheduleend =  $schedule_end_date_time - $currentDateTime ;
               $diffschedulestart = round($datediffschedulestart / (60 * 60 * 24));
               $diffscheduleend = round($datediffscheduleend / (60 * 60 * 24));
               if($diffschedulestart < 0)
               {
                   $schedule_start_count = 0;
               }
               else{
                $schedule_start_count = $diffschedulestart;
               }
               if($diffscheduleend < 0)
               {
                   $schedule_end_count = 0;
               }
               else{
                $schedule_end_count = $diffscheduleend;
               }
               $schedule_start = date('d/m/Y', strtotime($queryschedule->MAINTENANCE_START_DATE));
               $schedule_end = date('d/m/Y', strtotime($queryschedule->MAINTENANCE_END_DATE));
               // Log::info(print_r($query));
               $d = new \stdClass();
               $d->renewal_start_date = $renewal_start;
               $d->renewal_start_count = $start_count;
               $d->renewal_end_date = $renewal_end;
               $d->renewal_end_count = $end_count;
               $d->annual_fee_start_date = $annual_fee_start;
               $d->annual_fee_start_count = $annual_start_count;
               $d->annual_fee_end_date = $annual_fee_end;
               $d->annual_fee_end_count = $annual_end_count;
               $d->schedule_start_date = $schedule_start;
               $d->schedule_start_count = $schedule_start_count;
               $d->schedule_end_date = $schedule_end;
               $d->schedule_end_count = $annual_end_count;
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
    public function getAdminChartSettingFive(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Fimm Data
                $query = DB::table('admin_management.USER AS USER')
                ->select(DB::raw('count(*) as total'),'EVENT_ENTITY.IP_ADDRESS AS IP_ADDRESS')
                ->leftJoin(env('KEYCLOAK_DATABASE').'.EVENT_ENTITY AS EVENT_ENTITY', 'EVENT_ENTITY.USER_ID', '=', 'USER.KEYCLOAK_ID');
               $data= $query
               ->where('USER.KEYCLOAK_ID', '!=','')
               ->where('EVENT_ENTITY.IP_ADDRESS', '!=','')
               ->groupBy('EVENT_ENTITY.IP_ADDRESS')
               ->get();
                // Distributor Data
                $querydis = DB::table('distributor_management.USER AS USER')
                ->select(DB::raw('count(*) as total'),'EVENT_ENTITY.IP_ADDRESS AS IP_ADDRESS')
                ->leftJoin(env('KEYCLOAK_DATABASE').'.EVENT_ENTITY AS EVENT_ENTITY', 'EVENT_ENTITY.USER_ID', '=', 'USER.KEYCLOAK_ID');
               $datadist = $querydis
               ->where('USER.KEYCLOAK_ID', '!=','')
               ->where('EVENT_ENTITY.IP_ADDRESS', '!=','')
               ->groupBy('EVENT_ENTITY.IP_ADDRESS')
               ->get();
                // Consultant Data
                $querycon = DB::table('consultant_management.USER AS USER')
                ->select(DB::raw('count(*) as total'),'EVENT_ENTITY.IP_ADDRESS AS IP_ADDRESS')
                ->leftJoin(env('KEYCLOAK_DATABASE').'.EVENT_ENTITY AS EVENT_ENTITY', 'EVENT_ENTITY.USER_ID', '=', 'USER.KEYCLOAK_ID');
               $datacon = $querycon
               ->where('USER.KEYCLOAK_ID', '!=','')
               ->where('EVENT_ENTITY.IP_ADDRESS', '!=','')
               ->groupBy('EVENT_ENTITY.IP_ADDRESS')
               ->get();
                // Others Data
                $queryother = DB::table('funds_management.TP_USER AS TP_USER')
                ->select(DB::raw('count(*) as total'),'EVENT_ENTITY.IP_ADDRESS AS IP_ADDRESS')
                ->leftJoin(env('KEYCLOAK_DATABASE').'.EVENT_ENTITY AS EVENT_ENTITY', 'EVENT_ENTITY.USER_ID', '=', 'TP_USER.KEYCLOAK_ID');
               $dataother = $queryother
               ->where('TP_USER.KEYCLOAK_ID', '!=','')
               ->where('EVENT_ENTITY.IP_ADDRESS', '!=','')
               ->groupBy('EVENT_ENTITY.IP_ADDRESS')
               ->get();


               // $data = count($data);
              // Log::info(print_r($data));
               $d = new \stdClass();
               $d->fimm_data = $data;
               $d->dist_data = $datadist;
               $d->con_data = $datacon;
               $d->other_data = $dataother;
              // $d->module_data = $data2;
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
        $access_user_division = $request->ACCESS_USER_DIVISION;
        $access_user_departrment = $request->ACCESS_USER_DEPARTMENT;
        $super_user_department = 7;
        $access_user_group = $request->ACCESS_USER_GROUP;

            try {
                foreach ($req as $r) {
                        if(isset($r['setting_setup']['DISPLAY_SETTING_ID']))
                        {
                            $data =DashboardAdminDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardAdminDisplaySetting;
                        }
                            $data->DASHBOARD_SETTING_ID = $r['DASHBOARD_MAIN_ID'];
                            $data->SETTING_USER_ID = $user_id;
                            $data->SETTING_USER_TYPE = $user_type;
                            $data->SETTING_CHART_ID = $r['setting_setup']['SETTING_CHART_ID'];
                            $data->SETTING_INDEX = $r['setting_setup']['SETTING_INDEX'];
                            $data->SETTING_STATUS = $r['setting_setup']['SETTING_STATUS'];
                            $data->DISPLAY_SETTING_STYLE = 'Yearly';
                            $data->ACCESS_USER_DIVISION = $access_user_division;
                            $data->ACCESS_USER_DEPARTMENT = $access_user_departrment;
                            $data->SUPER_USER_DEPARTMENT = $super_user_department;
                            $data->ACCESS_USER_GROUP = $access_user_group;
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
            //Log::info( "POST ID ===>" . $request);
            try {
            $data = DashboardAdminDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

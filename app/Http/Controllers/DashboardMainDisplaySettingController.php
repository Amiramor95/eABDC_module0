<?php

namespace App\Http\Controllers;

use App\Models\DashboardMainDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardMainDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            Log::info( "User ID ===>" . $request->SETTING_USER_ID);
            $data_main = DashboardMainDisplaySetting::where('SETTING_USER_ID',$request->SETTING_USER_ID)->where('SETTING_USER_TYPE',$request->SETTING_USER_TYPE)->first();
          //  $data_admin = DashboardMainDisplaySetting::where('ACCESS_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
           // ->orWhere('SUPER_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)->first();
            if($data_main){
                //Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_MAIN_DISPLAY_SETTING AS DASHBOARD_MAIN_DISPLAY_SETTING')
                ->select('DASHBOARD_MAIN_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_MAIN_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID','DASHBOARD_MAIN_DISPLAY_SETTING.DASHBOARD_TYPE AS DASHBOARD_TYPE')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_MAIN_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
              //  ->where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
               ->where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               ->Where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
                ->orderBy('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_INDEX', 'asc')
                ->get();
               // Log::info($data);
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
    // CPD Module
    public function getCPDChartSettingOne(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousYear = $previousDate->format('Y');
            Log::info( "chartview ===>" . $chartview);
            $currentYear = Carbon::now()->format('Y');
            $totalArray = array(1,2,3,4,5,6,7,8,9,10,11,12);
            $dataYear= [$currentYear,$previousYear];
                $query = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')
                 ->select(DB::raw('YEAR(DISTRIBUTOR.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(DISTRIBUTOR.CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
                 ->join('distributor_management.DISTRIBUTOR_STATUS AS DISTRIBUTOR_STATUS', 'DISTRIBUTOR_STATUS.DIST_ID', '=', 'DISTRIBUTOR.DISTRIBUTOR_ID');
                // if($request->CHART_VIEW == 'Weekly')
                // {
                //     $query->whereBetween('DISTRIBUTOR.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Monthly')
                // {
                //     Log::info( "chartview ===>" . $chartview);
                //     Log::info( "Weekly ===>" . $newDateTimeWeekly);
                //     $query->whereBetween('DISTRIBUTOR.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Yearly')
                // {
                //     $query->whereBetween('DISTRIBUTOR.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
                // }
                $data = $query
                ->whereIN(DB::raw('YEAR(DISTRIBUTOR.CREATE_TIMESTAMP)'), $dataYear)
                ->groupBy(DB::raw('MONTH(DISTRIBUTOR.CREATE_TIMESTAMP)'))
                //->groupBy(DB::raw('YEAR(DISTRIBUTOR.CREATE_TIMESTAMP)'))
                ->orderBy(DB::raw('MONTH(DISTRIBUTOR.CREATE_TIMESTAMP)'), 'asc')
                ->where('DISTRIBUTOR_STATUS.DIST_VALID_STATUS', '=' , 1)
                ->get();

            //    $dt =array();
            //    $ta1 = array();
            //    $databymonth = array();
            //    foreach ($data as $d1) {
            //     array_push($ta1, $d1->month);
            //     $dt['month'] =  $d1->month;
            //     $dt['total'] = $d1->total;
            //     array_push($databymonth, $dt);
            //    }
            //    foreach($totalArray as $ta){
            //     if(!in_array($ta, $ta1)){
            //         $dt['month'] = $ta;
            //         $dt['total'] = 0;
            //         array_push($databymonth, $dt);
            //     }
            //   }
            //   sort($databymonth);
               // Log::info(print_r($data));

               $query1 = DB::table('funds_management.TP_USER AS TP_USER')
               ->select(DB::raw('YEAR(TP_USER.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(TP_USER.CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
               ->join('funds_management.TP_APPROVAL AS TP_APPROVAL', 'TP_APPROVAL.TP_USER_ID', '=', 'TP_USER.TP_USER_ID');
               $data1 = $query1
               ->whereIN(DB::raw('YEAR(TP_USER.CREATE_TIMESTAMP)'), $dataYear)
               ->groupBy(DB::raw('MONTH(TP_USER.CREATE_TIMESTAMP)'))
               ->orderBy(DB::raw('MONTH(TP_USER.CREATE_TIMESTAMP)'), 'asc')
               ->where('TP_APPROVAL.TS_ID', '=' , 3)
               ->get();

                 // Log::info(print_r($data1));
            //    $dt1 =array();
            //    $ta2 = array();
            //    $databymonth1 = array();
            //    foreach ($data1 as $d2) {
            //     array_push($ta2, $d2->month);
            //     $dt1['month'] =  $d2->month;
            //     $dt1['total'] = $d2->total;
            //     array_push($databymonth1, $dt1);
            //    }
            //    foreach($totalArray as $t){
            //     if(!in_array($t, $ta2)){
            //         $d1t['month'] = $t;
            //         $dt1['total'] = 0;
            //         array_push($databymonth1, $dt1);
            //     }
            //   }
            //   sort($databymonth1);
               // $data = count($data);
               // Log::info(print_r($data));
               $d = new \stdClass();
               $d->distributor_data = $data;
               $d->training_provider = $data1;
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
    public function getCPDChartSettingTwo(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            $currentYear = Carbon::now()->format('Y');
            Log::info( "chartview ===>" . $chartview);
            // Post Vetting Data
                $query = DB::table('cpd_management.PROGRAM AS PROGRAM')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                 ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');

               $data = $query
                    ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                    ->where('PROGRAM.PROG_TYPE', '=' , 1)
                    ->count();
               // Pre Vetting Data
               $query1 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');

              $data1 = $query1
                      ->where('PROGRAM.PROG_TYPE', '=' , 2)
                      ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                      ->count();

                // 5 Module Data
                $query2 = DB::table('cpd_management.MODULE AS MODULE')
                 ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
               $data2 = $query2
                     ->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 1)
                     ->where(DB::raw('YEAR(MODULE.CREATE_TIMESTAMP)'),'=', $currentYear)
                     ->count();

               // $data = count($data);
               // Log::info(print_r($data));
               $d = new \stdClass();
               $d->post_data = $data;
               $d->pre_data = $data1;
               $d->module_data = $data2;
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
    public function getCPDChartSettingThree(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            $currentYear = Carbon::now()->format('Y');
            // Distributor Approve or Submit Data
                $query = DB::table('cpd_management.PROGRAM AS PROGRAM')
                ->select(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
                 ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');

               $data = $query
                        ->where('PROGRAM.CATEGORY', '=' , 2)
                        ->where('PROGRAM_APPROVAL.APPR_PUBLISH_STATUS', '=' , 1)
                        ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                        ->groupBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'))
                        ->orderBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'), 'asc')
                        ->get();
               // Distributor Pending Data
               $query1 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                        ->select(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(PROGRAM.  CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
                        ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
              $data1 = $query1
                        ->where('PROGRAM.CATEGORY', '=' , 2)
                        ->where('PROGRAM_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)
                        ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                        ->groupBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'))
                        ->orderBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'), 'asc')
                        ->get();
              // Training Provide Approve or Submit Data
              $query2 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                      ->select(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(PROGRAM.  CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
                      ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');

             $data2 = $query2
                    ->where('PROGRAM.CATEGORY', '=' , 3)
                    ->where('PROGRAM_APPROVAL.APPR_PUBLISH_STATUS', '=' , 1)
                    ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                    ->groupBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'))
                    ->orderBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'), 'asc')
                    ->get();
             // Training Pending Data
             $query4 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                     ->select(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP) as YEAR'),DB::raw('MONTH(PROGRAM.  CREATE_TIMESTAMP) as MONTH'),DB::raw('count(*) as total'))
                     ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');

            $data4 = $query4
                    ->where('PROGRAM.CATEGORY', '=' , 3)
                    ->where('PROGRAM_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)
                    ->where(DB::raw('YEAR(PROGRAM.CREATE_TIMESTAMP)'),'=', $currentYear)
                    ->groupBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'))
                    ->orderBy(DB::raw('MONTH(PROGRAM.CREATE_TIMESTAMP)'), 'asc')
                    ->get();


               // $data = count($data);
              // Log::info(print_r($data));
               $d = new \stdClass();
               $d->distributor_submit_data = $data;
               $d->distributor_pending_data = $data1;
               $d->provide_submit_data = $data2;
               $d->provide_pending_data = $data4;
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
    public function getCPDChartSettingFour(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            Log::info( "chartview ===>" . $chartview);
            // Post-Vetting Pending  Data
                $query = DB::table('cpd_management.PROGRAM AS PROGRAM')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                 ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
                // if($request->CHART_VIEW == 'Weekly')
                // {
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Monthly')
                // {
                //     Log::info( "chartview ===>" . $chartview);
                //     Log::info( "Weekly ===>" . $newDateTimeWeekly);
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Yearly')
                // {
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
                // }
               $data = $query->where('PROGRAM.PROG_TYPE', '=' , 1)->where('PROGRAM_APPROVAL.TS_ID', '=' , 15)->count();
               // Post-Vetting Approve  Data
               $query1 = DB::table('cpd_management.PROGRAM AS PROGRAM')
               // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
            //    if($request->CHART_VIEW == 'Weekly')
            //    {
            //        $query1->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            //    }
            //    if($request->CHART_VIEW == 'Monthly')
            //    {
            //        $query1->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            //    }
            //    if($request->CHART_VIEW == 'Yearly')
            //    {
            //        $query1->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            //    }
              $data1 = $query1->where('PROGRAM.PROG_TYPE', '=' , 1)->where('PROGRAM_APPROVAL.TS_ID', '=' , 3)->count();
                // Post-Vetting Rejected  Data
                $query2 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                 ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
               $data2 = $query2->where('PROGRAM.PROG_TYPE', '=' , 1)->where('PROGRAM_APPROVAL.TS_ID', '=' , 5)->count();
                // Pre-Vetting Pending  Data
                $query3 = DB::table('cpd_management.PROGRAM AS PROGRAM')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
                $data3 = $query3->where('PROGRAM.PROG_TYPE', '=' , 2)->where('PROGRAM_APPROVAL.TS_ID', '=' , 15)->count();

                // Pre-Vetting Approved  Data
             $query4 = DB::table('cpd_management.PROGRAM AS PROGRAM')
             // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
              ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
            //  if($request->CHART_VIEW == 'Weekly')
            //  {
            //      $query4->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            //  }
            //  if($request->CHART_VIEW == 'Monthly')
            //  {
            //      $query4->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            //  }
            //  if($request->CHART_VIEW == 'Yearly')
            //  {
            //      $query4->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            //  }
            $data4 = $query4->where('PROGRAM.PROG_TYPE', '=' , 2)->where('PROGRAM_APPROVAL.TS_ID', '=' , 3)->count();

            // Pre-Vetting Rejected  Data
            $query5 = DB::table('cpd_management.PROGRAM AS PROGRAM')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
            // if($request->CHART_VIEW == 'Weekly')
            // {
            //     $query5->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Monthly')
            // {
            //     $query5->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Yearly')
            // {
            //     $query5->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            // }
             $data5 = $query5->where('PROGRAM.PROG_TYPE', '=' , 2)->where('PROGRAM_APPROVAL.TS_ID', '=' , 5)->count();

              // 5 Modules Pending Data
            $query6 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            // if($request->CHART_VIEW == 'Weekly')
            // {
            //     $query6->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Monthly')
            // {
            //     $query6->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Yearly')
            // {
            //     $query6->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            // }
             $data6 = $query6->where('MODULE_APPROVAL.TS_ID', '=' , 15)->count();

              // 5 Modules Approved Data
            $query7 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            // if($request->CHART_VIEW == 'Weekly')
            // {
            //     $query7->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Monthly')
            // {
            //     $query7->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Yearly')
            // {
            //     $query7->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            // }
             $data7 = $query7->where('MODULE_APPROVAL.TS_ID', '=' , 3)->count();

                // 5 Modules Rejected Data
            $query8 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            // if($request->CHART_VIEW == 'Weekly')
            // {
            //     $query8->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Monthly')
            // {
            //     $query8->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Yearly')
            // {
            //     $query8->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            // }
             $data8 = $query8->where('MODULE_APPROVAL.TS_ID', '=' , 5)->count();



               // $data = count($data);
               // Log::info(print_r($data));
               $d = new \stdClass();
            //    $d->postvetting_pending_data = $data;
            //    $d->postvetting_approve_data = $data1;
            //    $d->postvetting_rejected_data = $data2;
            //    $d->prevetting_pending_data = $data3;
            //    $d->prevetting_approve_data = $data4;
            //    $d->prevetting_rejected_data = $data5;
            //    $d->module_pending_data = $data6;
            //    $d->module_approve_data = $data7;
            //    $d->module_rejected_data = $data8;
            $d->pending_data = $data+$data3+$data6;
            $d->approve_data = $data1+$data4+$data7;
            $d->rejected_data = $data2+$data5+$data8;
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
    public function getCPDChartSettingFive(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            Log::info( "chartview ===>" . $chartview);
            // Pre-vetting

                $query = DB::table('cpd_management.PROGRAM AS PROGRAM')
                ->select('PROGRAM.COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total'))
                 ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'PROGRAM.COMPANY_ID');
                // if($request->CHART_VIEW == 'Weekly')
                // {
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Monthly')
                // {
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
                // }
                // if($request->CHART_VIEW == 'Yearly')
                // {
                //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
                // }
               $data = $query->where('PROGRAM.PROG_TYPE', '=' , 2)->groupBy('PROGRAM.COMPANY_ID')->orderBy('total','desc')->take(10)->get();
               // 5 Modules
               $query1 = DB::table('cpd_management.MODULE AS MODULE')
                ->select('MODULE.COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total'))
                 ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'MODULE.COMPANY_ID');
               $data1 = $query1->groupBy('MODULE.COMPANY_ID')->orderBy('total','desc')->take(10)->get();

               // 5 Waiver
               $query2 = DB::table('cpd_management.WAIVER AS WAIVER')
                ->select('WAIVER.DISTRIBUTOR_ID AS COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total')) //DB::raw('count(*) as total')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                 ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'WAIVER.DISTRIBUTOR_ID');

               $data2 = $query2->groupBy('WAIVER.DISTRIBUTOR_ID')->orderBy('total','desc')->take(10)->get();

            //error_reporting(E_ALL ^ E_NOTICE);
            $merged = $data->merge($data1);
            $mergedfinal =$merged->merge($data2);
           // Log::info(print_r($mergedfinal));
            $out = array();
            foreach($mergedfinal as $x){
                $out[$x->COMPANY_ID]['total'] = 0;
            }
            foreach($mergedfinal as $x){
                if($x->COMPANY_ID == 0){
                    $x->DIST_NAME = 'FIMM';
                    // $x->COMPANY_ID = 1;
                }
                // Log::info(print_r($x));
                $out[$x->COMPANY_ID]['total'] += $x->total;
                $out[$x->COMPANY_ID]['COMPANY_ID'] = $x->COMPANY_ID;
                $out[$x->COMPANY_ID]['DIST_NAME'] = $x->DIST_NAME;
            }
            // arsort($out);
            // Log::info(print_r($out));
        // Bottom Company
            $querybottom = DB::table('cpd_management.PROGRAM AS PROGRAM')
            ->select('PROGRAM.COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total'))
             ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'PROGRAM.COMPANY_ID');
            // if($request->CHART_VIEW == 'Weekly')
            // {
            //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Monthly')
            // {
            //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            // }
            // if($request->CHART_VIEW == 'Yearly')
            // {
            //     $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            // }
           $databottom = $querybottom->where('PROGRAM.PROG_TYPE', '=' , 2)->groupBy('PROGRAM.COMPANY_ID')->orderBy('total','asc')->take(10)->get();
           // 5 Modules
           $querybottom1 = DB::table('cpd_management.MODULE AS MODULE')
            ->select('MODULE.COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total'))
             ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'MODULE.COMPANY_ID');
           $databottom1 = $querybottom1->groupBy('MODULE.COMPANY_ID')->orderBy('total','asc')->take(10)->get();

           // 5 Waiver
           $querybottom2 = DB::table('cpd_management.WAIVER AS WAIVER')
            ->select('WAIVER.DISTRIBUTOR_ID AS COMPANY_ID','DISTRIBUTOR.DIST_NAME',DB::raw('count(*) as total')) //DB::raw('count(*) as total')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->leftJoin('distributor_management.DISTRIBUTOR AS DISTRIBUTOR', 'DISTRIBUTOR.DISTRIBUTOR_ID', '=', 'WAIVER.DISTRIBUTOR_ID');

           $databottom2 = $querybottom2->groupBy('WAIVER.DISTRIBUTOR_ID')->orderBy('total','asc')->take(10)->get();
          
           $mergedbottom = $databottom->merge($databottom1);
           $mergedbottomfinal =$mergedbottom->merge($databottom2);
          // Log::info(print_r($mergedfinal));
           $outbottom = array();
           foreach($mergedbottomfinal as $y){
               $outbottom[$y->COMPANY_ID]['total'] = 0;
           }
           foreach($mergedbottomfinal as $y){
               if($y->COMPANY_ID == 0){
                   $y->DIST_NAME = 'FIMM';
                   // $x->COMPANY_ID = 1;
               }
               // Log::info(print_r($x));
               $outbottom[$y->COMPANY_ID]['total'] += $y->total;
               $outbottom[$y->COMPANY_ID]['COMPANY_ID'] = $y->COMPANY_ID;
               $outbottom[$y->COMPANY_ID]['DIST_NAME'] = $y->DIST_NAME;
           }
           $d = new \stdClass();
               $d->top_company_data = $out;
               $d->bottom_company_data = $outbottom;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' =>$d,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getCPDChartSettingSix(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            Log::info( "chartview ===>" . $chartview);
            // Pre-vetting Pending
                $query = DB::table('cpd_management.PROGRAM AS PROGRAM')
                // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                 ->join('cpd_management.PROGRAM_APPROVAL AS PROGRAM_APPROVAL', 'PROGRAM_APPROVAL.PROG_DETAILS_ID', '=', 'PROGRAM.PROGRAM_ID');
                if($request->CHART_VIEW == 'Weekly')
                {
                    $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
                }
                if($request->CHART_VIEW == 'Monthly')
                {
                    Log::info( "chartview ===>" . $chartview);
                    Log::info( "Weekly ===>" . $newDateTimeWeekly);
                    $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
                }
                if($request->CHART_VIEW == 'Yearly')
                {
                    $query->whereBetween('PROGRAM.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
                }
               $data = $query->where('PROGRAM.PROG_TYPE', '=' , 2)->where('PROGRAM_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();
               // 5 modules Writing Pending Data
               $query1 = DB::table('cpd_management.MODULE AS MODULE')
               // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
                ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
               if($request->CHART_VIEW == 'Weekly')
               {
                   $query1->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
               }
               if($request->CHART_VIEW == 'Monthly')
               {
                   $query1->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
               }
               if($request->CHART_VIEW == 'Yearly')
               {
                   $query1->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
               }
              $data1 = $query1->where('MODULE.MODULE_TYPE', '=' , 1)->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();

             // 5 modules Reading Pending Data
             $query2 = DB::table('cpd_management.MODULE AS MODULE')
             // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
              ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
             if($request->CHART_VIEW == 'Weekly')
             {
                 $query2->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
             }
             if($request->CHART_VIEW == 'Monthly')
             {

                 $query2->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
             }
             if($request->CHART_VIEW == 'Yearly')
             {
                 $query2->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
             }
            $data2 = $query2->where('MODULE.MODULE_TYPE', '=' , 2)->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();

            // 5 modules Teaching Pending Data
            $query3 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            if($request->CHART_VIEW == 'Weekly')
            {
                $query3->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Monthly')
            {

                $query3->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Yearly')
            {
                $query3->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            }
           $data3 = $query3->where('MODULE.MODULE_TYPE', '=' , 3)->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();

            // 5 modules Qualification Pending Data
            $query4 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            if($request->CHART_VIEW == 'Weekly')
            {
                $query4->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Monthly')
            {

                $query4->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Yearly')
            {
                $query4->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            }
           $data4 = $query4->where('MODULE.MODULE_TYPE', '=' , 4)->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();

            // 5 modules FP Pending Data
            $query5 = DB::table('cpd_management.MODULE AS MODULE')
            // ->select('count(DISTRIBUTOR.DISTRIBUTOR_ID *) AS totalActiveDistributor')
             ->join('cpd_management.MODULE_APPROVAL AS MODULE_APPROVAL', 'MODULE_APPROVAL.MODULE_ID', '=', 'MODULE.MODULE_ID');
            if($request->CHART_VIEW == 'Weekly')
            {
                $query5->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Monthly')
            {

                $query5->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeMonthly, $currentDateTime]);
            }
            if($request->CHART_VIEW == 'Yearly')
            {
                $query5->whereBetween('MODULE.CREATE_TIMESTAMP', [$newDateTimeYearly, $currentDateTime]);
            }
           $data5 = $query5->where('MODULE.MODULE_TYPE', '=' , 5)->where('MODULE_APPROVAL.APPR_PUBLISH_STATUS', '=' , 0)->count();


               // $data = count($data);
               // Log::info(print_r($data));
               $d = new \stdClass();
               $d->prevetting_pending_data = $data;
               $d->writing_pending_data = $data1;
               $d->reading_pending_data = $data2;
               $d->teaching_pending_data = $data3;
               $d->quali_pending_data = $data4;
               $d->fp_pending_data = $data5;
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
    public function getCPDChartSettingSeven(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentDateTime =  Carbon::now();
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            $newDateTimeMonthly = Carbon::now()->subDays(30);
            $newDateTimeYearly = Carbon::now()->subDays(365);
            Log::info( "chartview ===>" . $chartview);
            // Program Perticipant
                 $data16 = DB::table('cpd_management.PROGRAM_PARTICIPANT AS PROGRAM_PARTICIPANT')
                        ->where('PROGRAM_PARTICIPANT.APPROVE_POINT','>',16)
                        ->sum('PROGRAM_PARTICIPANT.APPROVE_POINT');
                $data16 = DB::table('cpd_management.PROGRAM_PARTICIPANT AS PROGRAM_PARTICIPANT')
                ->where('PROGRAM_PARTICIPANT.APPROVE_POINT','>',16)
                ->sum('PROGRAM_PARTICIPANT.APPROVE_POINT');


               //  Qualification Perticipant Approve point
               
               $query1 = DB::table('cpd_management.QUALIFICATION_PARTICIPANT AS QUALIFICATION_PARTICIPANT');
               $data1 = $query1->sum('QUALIFICATION_PARTICIPANT.APPROVE_POINT');

             // Reading Perticipant Approve Point
             $query2 = DB::table('cpd_management.READING_PARTICIPANT AS READING_PARTICIPANT');
             $data2 = $query2->sum('READING_PARTICIPANT.APPROVE_POINT');

            // TEACHING_PARTICIPANT
            $query3 = DB::table('cpd_management.TEACHING_PARTICIPANT AS TEACHING_PARTICIPANT');
            $data3 = $query3->sum('TEACHING_PARTICIPANT.APPROVE_POINT');

            // FP_PARTICIPANT
            $query4 = DB::table('cpd_management.FP_PARTICIPANT AS FP_PARTICIPANT');
            $data4 = $query4->sum('FP_PARTICIPANT.APPROVE_POINT');

            // WRITING_PARTICIPANT
            $query5 = DB::table('cpd_management.WRITING_PARTICIPANT AS WRITING_PARTICIPANT');
            $data5 = $query5->sum('WRITING_PARTICIPANT.APPROVE_POINT');

             // WAIVER_PARTICIPANT
            // $query6 = DB::table('cpd_management.WAIVER_PARTICIPANT AS WAIVER_PARTICIPANT');
             //$data6 = $query5->sum('WAIVER_PARTICIPANT.APPROVE_POINT');


               // $data = count($data);
               // Log::info(print_r($data));
               $d = new \stdClass();
               $d->program_data = $data;
               $d->quali_data = $data1;
               $d->reading_data = $data2;
               $d->teaching_data = $data3;
               $d->fp_data = $data4;
               $d->writing_data = $data5;
              // $d->waiver_data = $data6;
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
    public function getCPDChartSettingEight(Request $request)
    {
    }
    public function getCASChartSettingOne(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now();//->format('Y');
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousDate2 = Carbon::now()->subYear(3);
            $previousDate3 = Carbon::now()->subYear(4);
            $previousDate4 = Carbon::now()->subYear(5);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
            $previousYear2 = $previousDate2->format('Y');
            $previousYear3 = $previousDate3->format('Y');
            $previousYear4 = $previousDate4->format('Y');

            $totalArray = array(263,264,265,266,267,268,269);
                $query = DB::table('consultantAlert_management.CA_RECORD AS CA_RECORD')
                 ->select(DB::raw('IFNULL(count(*),0) as total'),DB::raw('YEAR(CA_RECORD_DETAILS.CA_DATE_START) as year'),'SETTING_GENERAL.SET_CODE as SET_CODE','SETTING_GENERAL.SETTING_GENERAL_ID as SETTING_GENERAL_ID')
                 ->join('consultantAlert_management.CA_RECORD_DETAILS AS CA_RECORD_DETAILS','CA_RECORD_DETAILS.CA_RECORD_ID', '=','CA_RECORD.CA_RECORD_ID')
                 ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CA_RECORD_DETAILS.CA_CLASSIFICATION');

               $data = $query
               ->whereIN('SETTING_GENERAL.SETTING_GENERAL_ID' ,  $totalArray)
               ->whereIN(DB::raw('YEAR(CA_RECORD_DETAILS.CA_DATE_START)'), [$previousYear, $previousYear1,$previousYear2,$previousYear3,$previousYear4])
               ->where('CA_RECORD_DETAILS.TS_ID','=',3)
               ->groupBy(DB::raw('YEAR(CA_RECORD_DETAILS.CA_DATE_START)'))
               ->groupBy('SETTING_GENERAL.SET_CODE')
              // ->groupBy(DB::Raw('IFNULL(CONSULTANT.CONSULTANT_STATUS, 0 )'))
               ->orderBy(DB::raw('YEAR(CA_RECORD_DETAILS.CA_DATE_START)'), 'desc')
               ->orderBy(DB::raw('SETTING_GENERAL.SETTING_GENERAL_ID'), 'asc')
               ->get();

             // var_dump(DB::getQueryLog());
             $datayear=array();
             $datafirst = array();
             $datafirstyear = array();
             $datasecondyear = array();
             $datathirdyear = array();
             $datafourthyear = array();
             $datafifthyear = array();
             $dt =array();
             $dt1 =array();
             $dt2 =array();
             $dt3 =array();
             $dt4 =array();
             $obj = new \stdClass();
             $ta1 = array();
             $ta2 = array();
             $ta3 = array();
             $ta4 = array();
             $ta5 = array();
            
             foreach ($data as $d) {
               if($d->year == $previousYear){
                    array_push($ta1, $d->SETTING_GENERAL_ID);
                    $dt['total'] = $d->total;
                    $dt['year'] = $previousYear;
                    $dt['SET_CODE'] = $d->SET_CODE;
                    $dt['SETTING_GENERAL_ID'] = $d->SETTING_GENERAL_ID;
                    array_push($datafirstyear, $dt);
                }
                if($d->year == $previousYear1){
                    array_push($ta2, $d->SETTING_GENERAL_ID);
                    $dt1['total'] = $d->total;
                    $dt1['year'] = $previousYear1;
                    $dt1['SET_CODE'] = $d->SET_CODE;
                    $dt1['SETTING_GENERAL_ID'] = $d->SETTING_GENERAL_ID;
                    array_push($datasecondyear, $dt1);
                }
                if($d->year == $previousYear2){
                    array_push($ta3, $d->SETTING_GENERAL_ID);
                    $dt2['total'] = $d->total;
                    $dt2['year'] = $previousYear2;
                    $dt2['SET_CODE'] = $d->SET_CODE;
                    $dt2['SETTING_GENERAL_ID'] = $d->SETTING_GENERAL_ID;
                    array_push($datathirdyear, $dt2);
                }
                if($d->year == $previousYear3){
                    array_push($ta4, $d->SETTING_GENERAL_ID);
                    $dt3['total'] = $d->total;
                    $dt3['year'] = $previousYear3;
                    $dt3['SET_CODE'] = $d->SET_CODE;
                    $dt3['SETTING_GENERAL_ID'] = $d->SETTING_GENERAL_ID;
                    array_push($datafourthyear, $dt3);
                }
                if($d->year == $previousYear4){
                    array_push($ta5, $d->SETTING_GENERAL_ID);
                    $dt4['total'] = $d->total;
                    $dt4['year'] = $previousYear4;
                    $dt4['SET_CODE'] = $d->SET_CODE;
                    $dt4['SETTING_GENERAL_ID'] = $d->SETTING_GENERAL_ID;
                    array_push($datafifthyear, $dt4);
                }
             }
            foreach($totalArray as $ta){
                if(!in_array($ta, $ta1)){
                    $dt['total'] = 0;
                    $dt['year'] = $previousYear;
                    $dt['SET_CODE'] = 'WATCHLIST';
                    $dt['SETTING_GENERAL_ID'] = $ta;
                    array_push($datafirstyear, $dt);
                }
            }
            usort($datafirstyear,function($a,$b){
              $cmp = strcmp($a['SETTING_GENERAL_ID'],$b['SETTING_GENERAL_ID']);
                return $cmp;
            });
            foreach($totalArray as $totalarry){
                if(!in_array($totalarry, $ta2)){
                    $dt1['total'] = 0;
                    $dt1['year'] = $previousYear1;
                    $dt1['SET_CODE'] = 'WATCHLIST';
                    $dt1['SETTING_GENERAL_ID'] = $totalarry;
                    array_push($datasecondyear, $dt1);
                }
            }
            usort($datasecondyear,function($a1,$b1){
              $cmp1 = strcmp($a1['SETTING_GENERAL_ID'],$b1['SETTING_GENERAL_ID']);
                return $cmp1;
            });
            foreach($totalArray as $totalarry1){
                if(!in_array($totalarry1, $ta3)){
                    $dt2['total'] = 0;
                    $dt2['year'] = $previousYear2;
                    $dt2['SET_CODE'] = 'WATCHLIST';
                    $dt2['SETTING_GENERAL_ID'] = $totalarry1;
                    array_push($datathirdyear, $dt2);
                }
            }
            usort($datathirdyear,function($a2,$b2){
              $cmp2 = strcmp($a2['SETTING_GENERAL_ID'],$b2['SETTING_GENERAL_ID']);
                return $cmp2;
            });
            foreach($totalArray as $totalarry2){
                if(!in_array($totalarry2, $ta4)){
                    $dt3['total'] = 0;
                    $dt3['year'] = $previousYear3;
                    $dt3['SET_CODE'] = 'WATCHLIST';
                    $dt3['SETTING_GENERAL_ID'] = $totalarry2;
                    array_push($datafourthyear, $dt3);
                }
            }
            usort($datafourthyear,function($a3,$b3){
              $cmp3 = strcmp($a3['SETTING_GENERAL_ID'],$b3['SETTING_GENERAL_ID']);
                return $cmp3;
            });
            foreach($totalArray as $totalarry3){
                if(!in_array($totalarry3, $ta5)){
                    $dt4['total'] = 0;
                    $dt4['year'] = $previousYear4;
                    $dt4['SET_CODE'] = 'WATCHLIST';
                    $dt4['SETTING_GENERAL_ID'] = $totalarry3;
                    array_push($datafifthyear, $dt4);
                }
            }
            usort($datafifthyear,function($a3,$b3){
              $cmp3 = strcmp($a3['SETTING_GENERAL_ID'],$b3['SETTING_GENERAL_ID']);
                return $cmp3;
            });
            $datayear = [$previousYear,$previousYear1,$previousYear2,$previousYear3,$previousYear4];
          // Log::info(print_r($datafifthyear));
               $d1 = new \stdClass();
               $d1->year = $datayear;
               $d1->firstYear = $datafirstyear;
               $d1->secondYear = $datasecondyear;
               $d1->thirdYear = $datathirdyear;
               $d1->fourthYear = $datafourthyear;
               $d1->fifthYear = $datafifthyear;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getCASChartSettingTwo(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Post Vetting Data
                $query = DB::table('consultantAlert_management.CA_APPROVAL AS CA_APPROVAL')
                ->select(DB::raw('count(*) as total'),'TASK_STATUS.TS_PARAM as TS_PARAM','TASK_STATUS.TS_ID as TS_ID')
                ->leftJoin('admin_management.TASK_STATUS AS TASK_STATUS', 'TASK_STATUS.TS_ID', '=', 'CA_APPROVAL.TS_ID');
                $data = $query
               ->whereIN('CA_APPROVAL.TS_ID' , [3,4,5,9,15])
               ->whereIN('CA_APPROVAL.APPROVAL_LEVEL_ID' , [105,107])
               //->groupBy('CA_APPROVAL.APPROVAL_LEVEL_ID')
               ->groupBy('CA_APPROVAL.TS_ID')
               ->orderBy('CA_APPROVAL.TS_ID', 'asc')
               ->orderBy('CA_APPROVAL.APPROVAL_LEVEL_ID', 'asc')
               ->get();
               // Pre Vetting Data


               // $data = count($data);
               // Log::info(print_r($data));
            //    $d = new \stdClass();
            //    $d->post_data = $data;
            //    $d->pre_data = $data1;
            //    $d->module_data = $data2;
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
    public function getCASChartSettingThree(Request $request)
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
    public function getCASChartSettingFour(Request $request)
    {
        // try{
        //     \DB::connection()->enableQueryLog();
        //     $chartview=$request->CHART_VIEW;
        //     $currentYear = Carbon::now()->format('Y');
        //     // $previousDate = Carbon::now()->subYear(1);
        //     // $previousDate1 = Carbon::now()->subYear(2);
        //     // $previousDate2 = Carbon::now()->subYear(3);
        //     // $previousDate3 = Carbon::now()->subYear(4);
        //     // $previousDate4 = Carbon::now()->subYear(5);
        //     // $previousYear = $previousDate->format('Y');
        //     // $previousYear1 = $previousDate1->format('Y');
        //     // $previousYear2 = $previousDate2->format('Y');
        //     // $previousYear3 = $previousDate3->format('Y');
        //     // $previousYear4 = $previousDate4->format('Y');

        //     Log::info( "currentYear ===>" . $currentYear);
        //         $query = DB::table('consultant_management.CONSULTANT AS CONSULTANT')
        //          ->select(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP) as month'),DB::raw('count(*) as total'))
        //          ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

        //        $data = $query
        //        ->whereIN('SETTING_GENERAL.SETTING_GENERAL_ID' , [263,264,265,266,267,268,269])
        //        ->whereIN(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'), [1, 2,3,4,5,6,7,8,9,10,11,12])
        //        ->where(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), '=', $currentYear)
        //        ->groupBy(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'))
        //       // ->groupBy('SETTING_GENERAL.SET_CODE')
        //       // ->groupBy(DB::Raw('IFNULL(CONSULTANT.CONSULTANT_STATUS, 0 )'))
        //        ->orderBy(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'), 'asc')
        //        ->orderBy(DB::raw('SETTING_GENERAL.SETTING_GENERAL_ID'), 'asc')
        //        ->get();

        //        $totalArray = array(1,2,3,4,5,6,7,8,9,10,11,12);
        //        $dt =array();
        //        $ta1 = array();
        //        $databymonth = array();
        //        foreach ($data as $d) {
        //         array_push($ta1, $d->month);
        //         $dt['month'] =  $d->month;
        //         $dt['total'] = $d->total;
        //         array_push($databymonth, $dt);
        //        }
        //        foreach($totalArray as $ta){
        //         if(!in_array($ta, $ta1)){
        //             $dt['month'] = $ta;
        //             $dt['total'] = 0;
        //             array_push($databymonth, $dt);
        //         }
        //       }
        //       sort($databymonth);
        //       $d1 = new \stdClass();
        //          $d1->month_data = $databymonth;
        //          $d1->year = $currentYear;

        //         http_response_code(200);
        //         return response([
        //         'message' => 'Data successfully retrieved.',
        //         'data' => $d1,
        //         ]);
        // } catch (RequestException $r) {
        //     http_response_code(400);
        //     return response([
        //     'message' => 'Failed to retrieve data.',
        //     'errorCode' => 4103
        //     ],400);
        // }
    }
    public function getCASChartSettingFive(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingOne(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingTwo(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingThree(Request $request)
    {
        try{
            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');
            // Log::info("month=".$currentMonth);
            // Log::info("day=".$currentday);
            $utc_pass = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'))
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT_LICENSE.CONSULTANT_ID')
            ->having('c', '=' , 1)
            ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',1)
            ->where('CONSULTANT_RESULT.CONSULTANT_RESULT','=',34)
            ->where(DB::raw('YEAR(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            //->orderBy(DB::raw('TRANSACTION_LEDGER.CREATE_TIMESTAMP'), 'desc')
            ->count();

            $prc_pass = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->select('CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID',DB::raw('count(CONSULTANT_LICENSE.CONSULTANT_ID) as c'))
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT_LICENSE.CONSULTANT_ID')
            ->having('c', '=' , 1)
            ->where('CONSULTANT_LICENSE.CONSULTANT_TYPE_ID','=',2)
            ->where('CONSULTANT_RESULT.CONSULTANT_RESULT','=',34)
            ->where(DB::raw('YEAR(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentMonth)
            ->where(DB::raw('DAY(CONSULTANT_RESULT.CREATE_TIMESTAMP)'),'=', $currentday)
            ->groupby('CONSULTANT_LICENSE.CONSULTANT_ID')
            //->orderBy(DB::raw('TRANSACTION_LEDGER.CREATE_TIMESTAMP'), 'desc')
            ->count();

            $dual_pass_same = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
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
            $dual_pass_diff = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
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
           // Log::info(print_r($utc_pass));
            $d = new \stdClass();
            $d->utc_pass = $utc_pass;
            $d->prc_pass = $prc_pass;
            $d->dual_pass_same = $dual_pass_same;
            $d->dual_pass_diff = $dual_pass_diff;
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
    public function getDISTRIBUTORChartSettingFour(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingFive(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingSix(Request $request)
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
    public function getDISTRIBUTORChartSettingSeven(Request $request)
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
           // $d->active_data = $active_data;
            $d->termination_data = $termination_data;
            $d->resignation_data = $resignation_data;
           // $d->revocation_data = $revocation_data;
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
    public function getDISTRIBUTORChartSettingEight(Request $request)
    {
        try{

        
            $dist_id = DB::table('distributor_management.USER AS USER')
            ->select('USER.USER_DIST_ID AS USER_DIST_ID')
            ->where('USER.USER_ID','=',$request->SETTING_USER_ID)
            ->first();
          //  Log::info("distid =".$dist_id->USER_DIST_ID);
          // Log::info(print_r($dist_id));
            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');

            $pre_balance = DB::table('finance_management.TRANSACTION_LEDGER AS TRANSACTION_LEDGER')
            ->select('TRANSACTION_LEDGER.OTHERS_AMOUNT AS OTHERS_AMOUNT')
            ->where('TRANSACTION_LEDGER.DISTRIBUTOR_ID','=',$dist_id->USER_DIST_ID)
            ->where('TRANSACTION_LEDGER.TRANS_STATUS','=',6)
            ->orderBy('TRANSACTION_LEDGER.CREATE_TIMESTAMP', 'desc')
            ->first();

            //Log::info(print_r($pre_balance));
            $d = new \stdClass();
           // $d->active_data = $active_data;
            $d->prepaid_balance = $pre_balance;
           // $d->resignation_data = $resignation_data;
           // $d->revocation_data = $revocation_data;
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
    public function getDISTRIBUTORChartSettingNine(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingTen(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingEleven(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingTwelve(Request $request)
    {
        try{

            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');

            $active_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',295)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            //->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();

            $termination_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->whereIN('CONSULTANT_LICENSE.CONSULTANT_STATUS', [296,297,298,299,300,301,302,303])
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
           // ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
            $resignation_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',304)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
           // ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
            $revocation_data = DB::table('consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE')
            ->where('CONSULTANT_LICENSE.CONSULTANT_STATUS','=',799)
            ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            //->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->count();
           // Log::info(print_r($approve_data));
            $d = new \stdClass();
           // $d->active_data = $active_data;
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
    public function getDISTRIBUTORChartSettingThirteen(Request $request)
    {
    }
    public function getDISTRIBUTORChartSettingFourteen(Request $request)
    {
        try{
            $dist_id = DB::table('distributor_management.USER AS USER')
            ->select('USER.USER_DIST_ID AS USER_DIST_ID')
            ->where('USER.USER_ID','=',$request->SETTING_USER_ID)
            ->first();
            $currentDateTime =  Carbon::now();
            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentday = Carbon::now()->format('d');
            $newDateTimeWeekly = Carbon::now()->subDays(7);
            //Log::info( "newDateTimeWeekly ===>" . $newDateTimeWeekly);
            $data = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')
            ->select(DB::raw('count(*) as total'),'CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME','CONSULTANT.CONSULTANT_ID AS CONSULTANT_ID')
            ->leftJoin('consultant_management.CONSULTANT AS CONSULTANT', 'CONSULTANT.DISTRIBUTOR_ID', '=', 'DISTRIBUTOR.DISTRIBUTOR_ID')
            ->join('consultant_management.CONSULTANT_RESULT AS CONSULTANT_RESULT', 'CONSULTANT_RESULT.CONSULTANT_ID', '=', 'CONSULTANT.CONSULTANT_ID')
             ->where('DISTRIBUTOR.DISTRIBUTOR_ID','=',$dist_id->USER_DIST_ID)
             ->whereBetween('CONSULTANT_RESULT.CREATE_TIMESTAMP', [$newDateTimeWeekly, $currentDateTime])
            // ->where(DB::raw('YEAR(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentYear)
            // ->where(DB::raw('MONTH(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentMonth)
            // ->where(DB::raw('DAY(CONSULTANT_LICENSE.CREATED_AT)'),'=', $currentday)
            ->groupBy(DB::raw('CONSULTANT_RESULT.CONSULTANT_ID'))
            ->get();

           
           // Log::info(print_r($data));
        //     $d = new \stdClass();
        //    // $d->active_data = $active_data;
        //     $d->termination_data = $termination_data;
        //     $d->resignation_data = $resignation_data;
        //    // $d->revocation_data = $revocation_data;
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
    public function getCONSULTANTChartSettingOne(Request $request)
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
    public function getCONSULTANTChartSettingTwo(Request $request)
    {
    }
    public function getCONSULTANTChartSettingThree(Request $request)
    {
    }
    public function getCONSULTANTChartSettingFour(Request $request)
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
    public function getCONSULTANTChartSettingFive(Request $request)
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
    public function getFMSChartSettingOne(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
            // $previousDate = Carbon::now()->subYear(1);
            // $previousDate1 = Carbon::now()->subYear(2);
            // $previousDate2 = Carbon::now()->subYear(3);
            // $previousDate3 = Carbon::now()->subYear(4);
            // $previousDate4 = Carbon::now()->subYear(5);
            // $previousYear = $previousDate->format('Y');
            // $previousYear1 = $previousDate1->format('Y');
            // $previousYear2 = $previousDate2->format('Y');
            // $previousYear3 = $previousDate3->format('Y');
            // $previousYear4 = $previousDate4->format('Y');

                $query = DB::table('funds_management.FUND_PROFILE AS FUND_PROFILE')
                 ->select(DB::raw('count(*) as total'),DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP) as year'));
                // ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

               $data = $query
               ->where('FUND_PROFILE.FUND_STATUS_FUND','=', 22)
               ->groupBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'))
              // ->where(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), '=',$currentYear)
              ->orderBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), 'desc')
               ->get();

             // var_dump(DB::getQueryLog());
          // Log::info(print_r($data));
               $d1 = new \stdClass();
               $d1->dataone = $data;
            //    $d1->firstYear = $datafirstyear;
            //    $d1->secondYear = $datasecondyear;
            //    $d1->thirdYear = $datathirdyear;
            //    $d1->fourthYear = $datafourthyear;
            //    $d1->fifthYear = $datafifthyear;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingTwo(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
            $mainArray = array(1,3,4,5,6,7,8,9);
                $query = DB::table('funds_management.FUND_PROFILE AS FUND_PROFILE')
                 ->select(DB::raw('count(*) as total'),'FMS_FUNDCATEGORY.GROUP_ASSET AS GROUP_ASSET','FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID AS FMS_FUNDCATEGORY_ID')
                ->leftJoin('admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY', 'FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID', '=', 'FUND_PROFILE.FUND_CATEGORY');
               $data = $query
               ->whereIn('FUND_PROFILE.FUND_CATEGORY', $mainArray)
               //->groupBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'))
               ->groupBy('FUND_PROFILE.FUND_CATEGORY')
               ->orderBy('FUND_PROFILE.FUND_CATEGORY', 'asc')
               ->orderBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), 'desc')
               ->get();

             // var_dump(DB::getQueryLog());
             $dt =array();
             $ta1 = array();
             $dataCategory = array();
             foreach ($data as $datadis) {
                array_push($ta1, $datadis->FMS_FUNDCATEGORY_ID);
                $dt['total'] = $datadis->total;
                $dt['FMS_FUNDCATEGORY_ID'] = $datadis->FMS_FUNDCATEGORY_ID;
                $dt['GROUP_ASSET'] = $datadis->GROUP_ASSET;
                array_push($dataCategory, $dt);
            }
            foreach($mainArray as $ta){
                if(!in_array($ta, $ta1)){
                    $dt['total'] = 0;
                    $dt['FMS_FUNDCATEGORY_ID'] = $ta;
                if($ta == 1)
                {
                    $dt['GROUP_ASSET'] = "BOND";
                }
                if($ta == 3)
                {
                    $dt['GROUP_ASSET'] = "MONEY MARKET";
                }
                if($ta == 4)
                {
                    $dt['GROUP_ASSET'] = "OTHERS - 1";
                }
                if($ta == 5)
                {
                    $dt['GROUP_ASSET'] = "ALTERNATIVES";
                }
                if($ta == 6)
                {
                    $dt['GROUP_ASSET'] = "COMMODITY";
                }
                if($ta == 7)
                {
                    $dt['GROUP_ASSET'] = "EQUITY";
                }
                if($ta == 8)
                {
                    $dt['GROUP_ASSET'] = "MIXED ASSET";
                }
                if($ta == 79)
                {
                    $dt['GROUP_ASSET'] = "OTHERS - 2";
                }
                    array_push($dataCategory, $dt);
                }
            }

           // Log::info(print_r($dataCategory));
               //$d1 = array(); //new \stdClass();
               //$d1['datacategory'] = $dataCategory;
            //    $d1->firstYear = $datafirstyear;
            //    $d1->secondYear = $datasecondyear;
            //    $d1->thirdYear = $datathirdyear;
            //    $d1->fourthYear = $datafourthyear;
            //    $d1->fifthYear = $datafifthyear;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $dataCategory,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingThree(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
            $mainArray = array(0,1);
                $query = DB::table('funds_management.FUND_PROFILE AS FUND_PROFILE')
                 ->select(DB::raw('count(*) as total'),'FUND_PROFILE.FUND_SYARIAH_COMP as FUND_SYARIAH_COMP');
               // ->leftJoin('admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY', 'FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID', '=', 'FUND_PROFILE.FUND_CATEGORY');
               $data = $query
               ->whereIn('FUND_PROFILE.FUND_SYARIAH_COMP', $mainArray)
               //->groupBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'))
               ->groupBy('FUND_PROFILE.FUND_SYARIAH_COMP')
               ->orderBy('FUND_PROFILE.FUND_SYARIAH_COMP', 'asc')
               ->orderBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), 'desc')
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
    public function getFMSChartSettingFour(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
           // $mainArray = array(0,1);
           // Fund Submission
                $query = DB::table('funds_management.FUND_CREATION_APPROVAL AS FUND_CREATION_APPROVAL');
                $fund_sub = $query
                ->where('FUND_CREATION_APPROVAL.TS_ID', '=', 15)
                ->count();
                // Update Submission
                $query1 = DB::table('funds_management.TEMP_APPROVAL AS TEMP_APPROVAL');
                $update_sub = $query1
                ->where('TEMP_APPROVAL.TS_ID', '=', 15)
                ->count();
                //Closure Submission
                $query2 = DB::table('funds_management.APPLICATION_APPROVAL AS APPLICATION_APPROVAL');
                $closure_sub = $query2
                ->where('APPLICATION_APPROVAL.TS_ID', '=', 15)
                ->count();
                 //NAV Submission
                 $query3 = DB::table('funds_management.NAV_APPROVAL AS NAV_APPROVAL');
                 $nav_sub = $query3
                 ->where('NAV_APPROVAL.TS_ID', '=', 15)
                 ->count();


               //Log::info(print_r($fund_sub));
               $d1 = new \stdClass();
               $d1->fund_submission = $fund_sub;
               $d1->update_submission = $update_sub;
               $d1->closure_submission = $closure_sub;
               $d1->nav_submission = $nav_sub;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingFive(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
           // $mainArray = array(0,1);
           // Fund Submission
                $query = DB::table('funds_management.NAV_LIST AS NAV_LIST');
                $nav_sub = $query
                ->where('NAV_LIST.NAV_STATUS', '=', 15)
                ->get();

             //  Log::info(print_r($nav_sub));
               $d1 = new \stdClass();
               $d1->nav_submission = $nav_sub;
              // $d1->update_submission = $update_sub;
              // $d1->closure_submission = $closure_sub;
              // $d1->nav_submission = $nav_sub;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingSix(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
           // $mainArray = array(0,1);
           // Fund Submission
                $query = DB::table('funds_management.NAV_LIST AS NAV_LIST');
                $nav_sub = $query
                ->where('NAV_LIST.NAV_STATUS', '=', 15)
                ->get();

             //  Log::info(print_r($nav_sub));
               $d1 = new \stdClass();
               $d1->nav_submission = $nav_sub;
              // $d1->update_submission = $update_sub;
              // $d1->closure_submission = $closure_sub;
              // $d1->nav_submission = $nav_sub;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingSeven(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Lodgement Data
            $mainArray = array(3,5,2);
                $query = DB::table('funds_management.FUND_LODGEMENT AS FUND_LODGEMENT')
                ->select(DB::raw('count(*) as total'),'TASK_STATUS.TS_PARAM as TS_PARAM','TASK_STATUS.TS_ID as TS_ID')
                ->join('funds_management.LODGEMENT_APPROVAL AS LODGEMENT_APPROVAL', 'LODGEMENT_APPROVAL.FUND_LODG_ID', '=', 'FUND_LODGEMENT.FUND_LODG_ID')
                ->leftJoin('admin_management.TASK_STATUS AS TASK_STATUS', 'TASK_STATUS.TS_ID', '=', 'LODGEMENT_APPROVAL.TS_ID');
                $data = $query
               ->whereIN('LODGEMENT_APPROVAL.TS_ID' , $mainArray)
               ->groupBy('LODGEMENT_APPROVAL.TS_ID')
               ->orderBy('LODGEMENT_APPROVAL.TS_ID', 'asc')
               //->orderBy('CA_APPROVAL.APPROVAL_LEVEL_ID', 'asc')
               ->get();
               // Dislodgement Data
               $queryd = DB::table('funds_management.FUND_LODGEMENT AS FUND_LODGEMENT')
               ->select(DB::raw('count(*) as total'),'TASK_STATUS.TS_PARAM as TS_PARAM','TASK_STATUS.TS_ID as TS_ID')
               ->join('funds_management.DISLODGEMENT_APPROVAL AS DISLODGEMENT_APPROVAL', 'DISLODGEMENT_APPROVAL.FUND_LODG_ID', '=', 'FUND_LODGEMENT.FUND_LODG_ID')
               ->leftJoin('admin_management.TASK_STATUS AS TASK_STATUS', 'TASK_STATUS.TS_ID', '=', 'DISLODGEMENT_APPROVAL.TS_ID');
               $datadislodgement = $queryd
              ->whereIN('DISLODGEMENT_APPROVAL.TS_ID' , $mainArray)
              ->groupBy('DISLODGEMENT_APPROVAL.TS_ID')
              ->orderBy('DISLODGEMENT_APPROVAL.TS_ID', 'asc')
              //->orderBy('CA_APPROVAL.APPROVAL_LEVEL_ID', 'asc')
              ->get();
              $dt =array();
              $ta1 = array();
              $datadislodgementmain = array();
              $dt1 =array();
              $ta2 = array();
              $datalodgementmain = array();
              foreach ($data as $datalos) {
                array_push($ta2, $datalos->TS_ID);
                $dt1['total'] = $datalos->total;
                $dt1['TS_PARAM'] = $datalos->TS_PARAM;
                $dt1['TS_ID'] = $datalos->TS_ID;
                array_push($datalodgementmain, $dt1);
            }
            foreach($mainArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0;
                if($ta_l == 2)
                {
                    $dt1['TS_PARAM'] = "NEW ENTRY";
                }
                if($ta_l == 3)
                {
                    $dt1['TS_PARAM'] = "APPROVED";
                }
                if($ta_l == 5)
                {
                    $dt1['TS_PARAM'] = "REJECTED";
                }
                    $dt1['TS_ID'] = $ta_l;
                    array_push($datalodgementmain, $dt1);
                }
            }
            usort($datalodgementmain,function($a1,$b1){
            $cmp1 = strcmp($a1['TS_ID'],$b1['TS_ID']);
            return $cmp1;
            });


                foreach ($datadislodgement as $datadis) {
                    array_push($ta1, $datadis->TS_ID);
                    $dt['total'] = $datadis->total;
                    $dt['TS_PARAM'] = $datadis->TS_PARAM;
                    $dt['TS_ID'] = $datadis->TS_ID;
                    array_push($datadislodgementmain, $dt);
                }
                foreach($mainArray as $ta){
                    if(!in_array($ta, $ta1)){
                        $dt['total'] = 0;
                    if($ta == 2)
                    {
                        $dt['TS_PARAM'] = "NEW ENTRY";
                    }
                    if($ta == 3)
                    {
                        $dt['TS_PARAM'] = "APPROVED";
                    }
                    if($ta == 5)
                    {
                        $dt['TS_PARAM'] = "REJECTED";
                    }
                        $dt['TS_ID'] = $ta;
                        array_push($datadislodgementmain, $dt);
                    }
                }
            usort($datadislodgementmain,function($a,$b){
                $cmp = strcmp($a['TS_ID'],$b['TS_ID']);
                  return $cmp;
              });

               // $data = count($data);
             //  Log::info(print_r($data));
               $d = new \stdClass();
               $d->lodgement_data = $datalodgementmain;
               $d->dislodgement_data = $datadislodgementmain;
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
    public function getFMSChartSettingEight(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            $currentYear = Carbon::now()->format('Y');
            // $previousDate = Carbon::now()->subYear(1);
            // $previousDate1 = Carbon::now()->subYear(2);
            // $previousDate2 = Carbon::now()->subYear(3);
            // $previousDate3 = Carbon::now()->subYear(4);
            // $previousDate4 = Carbon::now()->subYear(5);
            // $previousYear = $previousDate->format('Y');
            // $previousYear1 = $previousDate1->format('Y');
            // $previousYear2 = $previousDate2->format('Y');
            // $previousYear3 = $previousDate3->format('Y');
            // $previousYear4 = $previousDate4->format('Y');

                $query = DB::table('funds_management.FUND_PROFILE AS FUND_PROFILE')
                 ->select(DB::raw('count(*) as total'),DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP) as year'));
                // ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

               $data = $query
               ->where('FUND_PROFILE.FUND_STATUS_FUND','=', 22)
               ->groupBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'))
              // ->where(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), '=',$currentYear)
              ->orderBy(DB::raw('YEAR(FUND_PROFILE.CREATE_TIMESTAMP)'), 'desc')
               ->get();

             // var_dump(DB::getQueryLog());
          // Log::info(print_r($data));
               $d1 = new \stdClass();
               $d1->dataone = $data;
            //    $d1->firstYear = $datafirstyear;
            //    $d1->secondYear = $datasecondyear;
            //    $d1->thirdYear = $datathirdyear;
            //    $d1->fourthYear = $datafourthyear;
            //    $d1->fifthYear = $datafifthyear;
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $d1,
                ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFMSChartSettingNine(Request $request)
    {
        try{
            \DB::connection()->enableQueryLog();
            $chartview=$request->CHART_VIEW;
            // Lodgement Data
           // Log::info("Nishi");
           $currentYear = Carbon::now()->format('Y');
           $currentMonth = Carbon::now()->format('M');
           $previousDate = Carbon::now()->subMonth(1);
           $previousDate1 = Carbon::now()->subMonth(2);
           $previousDate2 = Carbon::now()->subMonth(3);
           $previousMonth = $previousDate->format('m');
           $previousMonth1 = $previousDate1->format('m');
           $previousMonth2 = $previousDate2->format('m');
           $previousMonthName = $previousDate->format('F');
           $previousMonthName1 = $previousDate1->format('F');
           $previousMonthName2 = $previousDate2->format('F');
          // Log::info("previousMonth=".$previousMonthName.$previousMonthName1.$previousMonthName1);
            $mainArray = array(1,2,3,4,5,6);

                $query = DB::table('funds_management.FUND_LODGEMENT AS FUND_LODGEMENT')
                ->select(DB::raw('count(FUND_LODGEMENT.DIST_ID) as total'),'DISTRIBUTOR_TYPE.DIST_TYPE as DIST_TYPE','ADMIN_DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME')
                ->join('distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE', 'DISTRIBUTOR_TYPE.DIST_ID', '=', 'FUND_LODGEMENT.DIST_ID')
                ->leftJoin('admin_management.DISTRIBUTOR_TYPE AS ADMIN_DISTRIBUTOR_TYPE', 'ADMIN_DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID', '=', 'DISTRIBUTOR_TYPE.DIST_TYPE');
                $data = $query
               ->whereIN('DISTRIBUTOR_TYPE.DIST_TYPE' , $mainArray)
                ->whereIN(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'), [$previousMonth, $previousMonth1,$previousMonth2])
               ->groupBy('DISTRIBUTOR_TYPE.DIST_TYPE')
              // ->groupBy(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'))
               ->orderBy('ADMIN_DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID', 'asc')
              // ->orderBy(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'), 'desc')
               ->get();
             //  var_dump(DB::getQueryLog());

             // Log::info(print_r($data));
              $dt =array();
              $ta1 = array();
              $datadislodgementmain = array();
              $dt1 =array();
              $ta2 = array();
              $datalodgementmain = array();
              $dataMonth=array();
              $dataMonth = [$previousMonthName,$previousMonthName1,$previousMonthName2];

                foreach ($data as $datadis) {
                    array_push($ta1, $datadis->DIST_TYPE);
                    $dt['total'] = $datadis->total;
                    $dt['DIST_TYPE'] = $datadis->DIST_TYPE;
                    $dt['DIST_TYPE_NAME'] = $datadis->DIST_TYPE_NAME;
                    array_push($datalodgementmain, $dt);
                }
                foreach($mainArray as $ta){
                    if(!in_array($ta, $ta1)){
                        $dt['total'] = 0;
                        $dt['DIST_TYPE'] = $ta;
                    if($ta == 1)
                    {
                        $dt['DIST_TYPE_NAME'] = "UTMC";
                    }
                    if($ta == 2)
                    {
                        $dt['DIST_TYPE_NAME'] = "PRP";
                    }
                    if($ta == 3)
                    {
                        $dt['DIST_TYPE_NAME'] = "IUTA";
                    }
                    if($ta == 4)
                    {
                        $dt['DIST_TYPE_NAME'] = "CUTA";
                    }
                    if($ta == 5)
                    {
                        $dt['DIST_TYPE_NAME'] = "CPRA";
                    }
                    if($ta == 6)
                    {
                        $dt['DIST_TYPE_NAME'] = "IPRA";
                    }
                        array_push($datalodgementmain, $dt);
                    }
                }
            // usort($datadislodgementmain,function($a,$b){
            //     $cmp = strcmp($a['TS_ID'],$b['TS_ID']);
            //       return $cmp;
            //   });

               // $data = count($data);
              // Log::info(print_r($data));
               $d = new \stdClass();
               $d->lodgementtype_data = $datalodgementmain;
              // $d->month_data =  $dataMonth;
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
    public function getFINANCEChartSettingOne(Request $request)
    {
        try{

            $approve_data = DB::table('finance_management.TRANSACTION_LEDGER AS TRANSACTION_LEDGER')
           // ->select('TRANSACTION_LEDGER.OTHERS_AMOUNT AS OTHERS_AMOUNT')
            ->where('TRANSACTION_LEDGER.FIN_TRANS_TYPE', '=' , 3)
            ->where('TRANSACTION_LEDGER.TRANS_STATUS', '=' , 6)
            //->orderBy(DB::raw('TRANSACTION_LEDGER.CREATE_TIMESTAMP'), 'desc')
            ->count();
            $pending_data = DB::table('finance_management.TRANSACTION_LEDGER AS TRANSACTION_LEDGER')
            //->select('TRANSACTION_LEDGER.OTHERS_AMOUNT AS OTHERS_AMOUNT')
            ->where('TRANSACTION_LEDGER.FIN_TRANS_TYPE', '=' , 3)
            ->where('TRANSACTION_LEDGER.TRANS_STATUS', '=' , 15)
            //->orderBy(DB::raw('TRANSACTION_LEDGER.CREATE_TIMESTAMP'), 'desc')
            ->count();
           // Log::info(print_r($approve_data));
            $d = new \stdClass();
            $d->approve_data = $approve_data;
            $d->pending_data = $pending_data;
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
    public function getFINANCEChartSettingTwo(Request $request)
    {
        try{

            $data = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')
            ->select('DISTRIBUTOR.DIST_NAME AS DIST_NAME','TRANSACTION_LEDGER.DISTRIBUTOR_ID AS DISTRIBUTOR_ID','TRANSACTION_LEDGER.OTHERS_AMOUNT AS OTHERS_AMOUNT')
            ->Join('finance_management.TRANSACTION_LEDGER AS TRANSACTION_LEDGER','TRANSACTION_LEDGER.DISTRIBUTOR_ID', '=', 'DISTRIBUTOR.DISTRIBUTOR_ID')
            ->where('TRANSACTION_LEDGER.FIN_TRANS_TYPE', '=' , 3)
            ->whereIN('TRANSACTION_LEDGER.TRANS_STATUS', [6,20])
            ->groupBy('DISTRIBUTOR_ID')
            ->orderBy('TRANSACTION_LEDGER.OTHERS_AMOUNT', 'desc')
            ->take(25)
            ->get();
           
           //Log::info(print_r($data));
           // $d = new \stdClass();
            //$d->data = $data;
            //$d->pending_data = $pending_data;
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
    public function create(Request $request)
    {

        $req = $request->params;
        $user_id=$request->userid;
        $user_type=$request->usertype;
        $user_department = 7;
        $super_user_department = 7;

            try {
                foreach ($req as $r) {
                        if(isset($r['setting_setup']['DISPLAY_SETTING_ID']))
                        {
                            $data =DashboardMainDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardMainDisplaySetting;
                        }
                            $data->DASHBOARD_SETTING_ID = $r['DASHBOARD_MAIN_ID'];
                            $data->SETTING_USER_ID = $user_id;
                            $data->SETTING_USER_TYPE = $user_type;
                            $data->SETTING_CHART_ID = $r['setting_setup']['SETTING_CHART_ID'];
                            $data->SETTING_INDEX = $r['setting_setup']['SETTING_INDEX'];
                            $data->SETTING_STATUS = $r['setting_setup']['SETTING_STATUS'];
                            $data->DISPLAY_SETTING_STYLE = 'Yearly';
                            $data->ACCESS_USER_DEPARTMENT = $user_department;
                            $data->SUPER_USER_DEPARTMENT = $super_user_department;
                            $data->DASHBOARD_TYPE = $r['DASHBOARD_TYPE'];
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
            $data = DashboardMainDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

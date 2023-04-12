<?php

namespace App\Http\Controllers;

use App\Models\DashboardCpdDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardCpdDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            $data_distributor = DashboardCpdDisplaySetting::where('ACCESS_USER_DIVISION',$request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_GROUP',$request->SETTING_USER_GROUP)
            ->first();
            if($data_distributor){
                Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_CPD_DISPLAY_SETTING AS DASHBOARD_CPD_DISPLAY_SETTING')
                ->select('DASHBOARD_CPD_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_CPD_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_CPD_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_CPD_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_CPD_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_CPD_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_CPD_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
                ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
                // ->orWhere('DASHBOARD_CPD_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
               // ->where('DASHBOARD_CPD_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_CPD_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
                ->orderBy('DASHBOARD_CPD_DISPLAY_SETTING.SETTING_INDEX', 'asc')
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
    public function getChartSetting(Request $request)
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
    public function getChartSettingTwo(Request $request)
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
    public function getChartSettingThree(Request $request)
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
    public function getChartSettingFour(Request $request)
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
    public function getChartSettingFive(Request $request)
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
    public function getChartSettingSix(Request $request)
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
    public function getChartSettingSeven(Request $request)
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
    public function getChartSettingEight(Request $request)
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

    public function create(Request $request)
    {

        $req = $request->params;
        $user_id=$request->userid;
        $user_type=$request->usertype;
        $access_user_division = $request->ACCESS_USER_DIVISION;
        $access_user_departrment = $request->ACCESS_USER_DEPARTMENT;
        $super_user_department = 7;
        $access_user_group = $request->ACCESS_USER_GROUP;
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
                            $data =DashboardCpdDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardCpdDisplaySetting;
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
            Log::info( "POST ID ===>" . $request);
            try {
            $data = DashboardCpdDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

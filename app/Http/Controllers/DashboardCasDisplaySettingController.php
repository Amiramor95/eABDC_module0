<?php

namespace App\Http\Controllers;

use App\Models\DashboardCasDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardCasDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            $data_distributor = DashboardCasDisplaySetting::where('ACCESS_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_DIVISION',$request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_GROUP',$request->SETTING_USER_GROUP)
           // ->orWhere('SUPER_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->first();
            if($data_distributor){
                Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_CAS_DISPLAY_SETTING AS DASHBOARD_CAS_DISPLAY_SETTING')
                ->select('DASHBOARD_CAS_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_CAS_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_CAS_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_CAS_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_CAS_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_CAS_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_CAS_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
               // ->where('DASHBOARD_CAS_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_CAS_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
               ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
               ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
               ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
               //->orWhere('DASHBOARD_CAS_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->orderBy('DASHBOARD_CAS_DISPLAY_SETTING.SETTING_INDEX', 'asc')
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

            // Log::info( "currentYear ===>" . $currentYear);
            // Log::info( "previousDate ===>" . $previousYear.$previousYear1.$previousYear2.$previousYear3.$previousYear4);
            //     $query = DB::table('consultant_management.CONSULTANT AS CONSULTANT')
            //      ->select(DB::raw('IFNULL(count(*),0) as total'),DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP) as year'),'SETTING_GENERAL.SET_CODE as SET_CODE','SETTING_GENERAL.SETTING_GENERAL_ID as SETTING_GENERAL_ID')
            //      ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

            //    $data = $query
            //    ->whereIN('SETTING_GENERAL.SETTING_GENERAL_ID' , [263,264,265,266,267,268,269])
            //    ->whereIN(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), [$previousYear, $previousYear1,$previousYear2,$previousYear3,$previousYear4])
            //    ->groupBy(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'))
            //    ->groupBy('SETTING_GENERAL.SET_CODE')
            //   // ->groupBy(DB::Raw('IFNULL(CONSULTANT.CONSULTANT_STATUS, 0 )'))
            //    ->orderBy(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), 'desc')
            //    ->orderBy(DB::raw('SETTING_GENERAL.SETTING_GENERAL_ID'), 'asc')
            //    ->get();

            //  // var_dump(DB::getQueryLog());
            //  $datayear=array();
            //  $datafirst = array();
            //  $datafirstyear = array();
            //  $datasecondyear = array();
            //  $datathirdyear = array();
            //  $datafourthyear = array();
            //  $datafifthyear = array();
            //  $dt =array();
            //  $dt1 =array();
            //  $dt2 =array();
            //  $dt3 =array();
            //  $dt4 =array();
            //  $obj = new \stdClass();
            //  $ta1 = array();
            //  $ta2 = array();
            //  $ta3 = array();
            //  $ta4 = array();
            //  $ta5 = array();
            //  $totalArray = array(263,264,265,266,267,268,269);
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
    public function getChartSettingTwo(Request $request)
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
    public function getChartSettingFour(Request $request)
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

            Log::info( "currentYear ===>" . $currentYear);
                $query = DB::table('consultant_management.CONSULTANT AS CONSULTANT')
                 ->select(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP) as month'),DB::raw('count(*) as total'))
                 ->leftJoin('admin_management.SETTING_GENERAL AS SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'CONSULTANT.CONSULTANT_STATUS');

               $data = $query
               ->whereIN('SETTING_GENERAL.SETTING_GENERAL_ID' , [263,264,265,266,267,268,269])
               ->whereIN(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'), [1, 2,3,4,5,6,7,8,9,10,11,12])
               ->where(DB::raw('YEAR(CONSULTANT.CREATE_TIMESTAMP)'), '=', $currentYear)
               ->groupBy(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'))
              // ->groupBy('SETTING_GENERAL.SET_CODE')
              // ->groupBy(DB::Raw('IFNULL(CONSULTANT.CONSULTANT_STATUS, 0 )'))
               ->orderBy(DB::raw('MONTH(CONSULTANT.CREATE_TIMESTAMP)'), 'asc')
               ->orderBy(DB::raw('SETTING_GENERAL.SETTING_GENERAL_ID'), 'asc')
               ->get();

               $totalArray = array(1,2,3,4,5,6,7,8,9,10,11,12);
               $dt =array();
               $ta1 = array();
               $databymonth = array();
               foreach ($data as $d) {
                array_push($ta1, $d->month);
                $dt['month'] =  $d->month;
                $dt['total'] = $d->total;
                array_push($databymonth, $dt);
               }
               foreach($totalArray as $ta){
                if(!in_array($ta, $ta1)){
                    $dt['month'] = $ta;
                    $dt['total'] = 0;
                    array_push($databymonth, $dt);
                }
              }
              sort($databymonth);
              $d1 = new \stdClass();
                 $d1->month_data = $databymonth;
                 $d1->year = $currentYear;

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
  
  

    public function create(Request $request)
    {

        $req = $request->params;
        $user_id=$request->userid;
        $user_type=$request->usertype;
        $access_user_division = $request->ACCESS_USER_DIVISION;
        $access_user_departrment = $request->ACCESS_USER_DEPARTMENT;
        $access_user_group = $request->ACCESS_USER_GROUP;
        $super_user_department = 7;
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
                            $data =DashboardCasDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardCasDisplaySetting;
                        }
                            $data->DASHBOARD_SETTING_ID = $r['DASHBOARD_MAIN_ID'];
                            $data->SETTING_USER_ID = $user_id;
                            $data->SETTING_USER_TYPE = $user_type;
                            $data->SETTING_CHART_ID = $r['setting_setup']['SETTING_CHART_ID'];
                            $data->SETTING_INDEX = $r['setting_setup']['SETTING_INDEX'];
                            $data->SETTING_STATUS = $r['setting_setup']['SETTING_STATUS'];
                            $data->DISPLAY_SETTING_STYLE = 'Yearly';
                            $data->ACCESS_USER_DEPARTMENT = $access_user_departrment;
                            $data->SUPER_USER_DEPARTMENT = $super_user_department;
                            $data->ACCESS_USER_DIVISION = $access_user_division;
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
            $data = DashboardCasDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

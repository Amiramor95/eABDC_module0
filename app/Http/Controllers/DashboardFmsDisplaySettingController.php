<?php

namespace App\Http\Controllers;

use App\Models\DashboardFmsDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardFmsDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{
           $user_department = $request->ACCESS_USER_DEPARTMENT;
        //    if($user_department == 4){
         
        //     $data_distributor = DashboardFmsDisplaySetting::where('SETTING_USER_TYPE_GROUP',1)->first();
        //     if($data_distributor){
        //        // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
        //         $data= DB::table('admin_management.DASHBOARD_FMS_DISPLAY_SETTING AS DASHBOARD_FMS_DISPLAY_SETTING')
        //         ->select('DASHBOARD_FMS_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_FMS_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
        //         ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_FMS_DISPLAY_SETTING.SETTING_CHART_ID')
        //         ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_FMS_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
        //        // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
        //        // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
        //         ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP', '=' ,1)
        //         ->orderBy('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_INDEX', 'asc')
        //         ->get();
        //         Log::info($data);
        //         http_response_code(200);
        //         return response([
        //         'message' => 'Data successfully retrieved.',
        //         'data' => $data
        //         ]);
        //   }
        //   else{
        //     http_response_code(400);
        //     return response([
        //     'message' => 'Data Not Found.',
        //     'errorCode' => 4103
        //     ]);
        //   }
        // }
        // else{
            $data_distributor = DashboardFmsDisplaySetting::where('ACCESS_USER_DIVISION', '=', $request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_DEPARTMENT', '=',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_GROUP','=',$request->SETTING_USER_GROUP)
            ->first();
            if($data_distributor){
               // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_FMS_DISPLAY_SETTING AS DASHBOARD_FMS_DISPLAY_SETTING')
                ->select('DASHBOARD_FMS_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_FMS_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID','DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP AS SETTING_USER_TYPE_GROUP')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_FMS_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_FMS_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
               // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
               // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
                // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP', '=' , 2)
                // ->where(function($query) {
                //     $query->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT1', '=' , 1)
                //     ->orWhere('DASHBOARD_FMS_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , 7);
                // })
                ->orderBy('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_INDEX', 'asc')
                ->get();
                Log::info($data);
                http_response_code(200);
                return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
                ]);
         // }
        //   else{
        //     http_response_code(400);
        //     return response([
        //     'message' => 'Data Not Found.',
        //     'errorCode' => 4103
        //     ]);
        //   }
        }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
    public function getFmsRdChartSetting(Request $request)
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
    public function getFmsRdChartSettingOne(Request $request)
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
                ->select(DB::raw('count(FUND_LODGEMENT.DIST_ID) as total'),'DISTRIBUTOR_TYPE.DIST_TYPE as DIST_TYPE','ADMIN_DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME',DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP) as month'))
                ->join('distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE', 'DISTRIBUTOR_TYPE.DIST_ID', '=', 'FUND_LODGEMENT.DIST_ID')
                ->leftJoin('admin_management.DISTRIBUTOR_TYPE AS ADMIN_DISTRIBUTOR_TYPE', 'ADMIN_DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID', '=', 'DISTRIBUTOR_TYPE.DIST_TYPE');
                $data = $query
               ->whereIN('DISTRIBUTOR_TYPE.DIST_TYPE' , $mainArray)
                ->whereIN(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'), [$previousMonth, $previousMonth1,$previousMonth2])
               ->groupBy('DISTRIBUTOR_TYPE.DIST_TYPE')
               ->groupBy(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'))
               ->orderBy('ADMIN_DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID', 'asc')
               ->orderBy(DB::raw('MONTH(FUND_LODGEMENT.CREATE_TIMESTAMP)'), 'desc')
               ->get();
             //  var_dump(DB::getQueryLog());

              Log::info(print_r($data));
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
               $d->month_data =  $dataMonth;
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
    public function getFmsRdChartSettingTwo(Request $request)
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
    public function getFmsIDChartSettingOne(Request $request)
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
    public function getFmsIDChartSettingTwo(Request $request)
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
    public function getFmsIDChartSettingThree(Request $request)
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
    public function getFmsIDChartSettingFour(Request $request)
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
    public function getFmsIDChartSettingFive(Request $request)
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
    public function getFmsIDChartSettingSix(Request $request)
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
    public function create(Request $request)
    {

        $req = $request->params;
        $user_id=$request->userid;
        $user_type=$request->usertype;
        $user_group=$request->usergroup;
        $user_group_type=$request->SETTING_USER_TYPE_GROUP;
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
                            $data =DashboardFmsDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardFmsDisplaySetting;
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
                            $data->SETTING_USER_TYPE_GROUP = $user_group_type;
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
            $data = DashboardFmsDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

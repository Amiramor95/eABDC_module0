<?php

namespace App\Http\Controllers;

use App\Models\DashboardAnnualDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardAnnualDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            $data_distributor = DashboardAnnualDisplaySetting::where('ACCESS_USER_DIVISION', '=', $request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_DEPARTMENT', '=',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_GROUP','=',$request->SETTING_USER_GROUP)
            ->first();

            if($data_distributor){
               // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_ANNUAL_DISPLAY_SETTING AS DASHBOARD_ANNUAL_DISPLAY_SETTING')
                ->select('DASHBOARD_ANNUAL_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_ANNUAL_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID','DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP AS SETTING_USER_TYPE_GROUP')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_ANNUAL_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
                ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE', '=' , 'ANNUAL')
                ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
                ->orderBy('DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_INDEX', 'asc')
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
    public function getAnnualChartSeven(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
                ->select(DB::raw('sum(AUM_ENTRY.AUM_AMOUNT) as total'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
                ->join('annualFee_management.AUM_ENTRY AS AUM_ENTRY', 'AUM_ENTRY.FUND_SUBMISSION_ID', '=', 'FUND_SUBMISSION.FUND_SUBMISSION_ID')
               ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
               ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=' , 'UTF')
               ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
               ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
               ->get();
               $queryPrc = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
               ->select(DB::raw('sum(AUM_ENTRY.AUM_AMOUNT) as total1'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
               ->join('annualFee_management.AUM_ENTRY AS AUM_ENTRY', 'AUM_ENTRY.FUND_SUBMISSION_ID', '=', 'FUND_SUBMISSION.FUND_SUBMISSION_ID')
              ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
              ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=' , 'PRC')
              ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
              ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
              ->get();
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->total;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                foreach ($queryPrc as $dataprc) {
                    array_push($ta4, $dataprc->AMSF_YEAR);
                    $dt2['total'] = $dataprc->total1;
                    $dt2['AMSF_YEAR'] = $dataprc->AMSF_YEAR;
                    array_push($dataprcmain, $dt2);
                }
                foreach($yearArray as $ta_2){
                   if(!in_array($ta_2, $ta4)){
                       $dt2['total'] = 0.00;
                       $dt2['AMSF_YEAR'] = $ta_2;
                       array_push($dataprcmain, $dt2);
                   }
                 }
                 usort($datautfmain,function($a1,$b1){
                   $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                   return $cmp1;
                   });
                   usort($dataprcmain,function($a2,$b2){
                    $cmp2 = strcmp($b2['AMSF_YEAR'],$a2['AMSF_YEAR']);
                    return $cmp2;
                    });

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->utf_data = $datautfmain;
             $d->prc_data = $dataprcmain;
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
    public function getAnnualChartEight(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
                ->select(DB::raw('sum(TGS_ENTRY.TGS_AMOUNT) as total'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
                ->join('annualFee_management.TGS_ENTRY AS TGS_ENTRY', 'TGS_ENTRY.FUND_SUBMISSION_ID', '=', 'FUND_SUBMISSION.FUND_SUBMISSION_ID')
               ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
               ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=' , 'UTF')
               ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
               ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
               ->get();
               $queryPrc = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
               ->select(DB::raw('sum(TGS_ENTRY.TGS_AMOUNT) as total1'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
               ->join('annualFee_management.TGS_ENTRY AS TGS_ENTRY', 'TGS_ENTRY.FUND_SUBMISSION_ID', '=', 'FUND_SUBMISSION.FUND_SUBMISSION_ID')
              ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
              ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=' , 'PRC')
              ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
              ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
              ->get();
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->total;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                foreach ($queryPrc as $dataprc) {
                    array_push($ta4, $dataprc->AMSF_YEAR);
                    $dt2['total'] = $dataprc->total1;
                    $dt2['AMSF_YEAR'] = $dataprc->AMSF_YEAR;
                    array_push($dataprcmain, $dt2);
                }
                foreach($yearArray as $ta_2){
                   if(!in_array($ta_2, $ta4)){
                       $dt2['total'] = 0.00;
                       $dt2['AMSF_YEAR'] = $ta_2;
                       array_push($dataprcmain, $dt2);
                   }
                 }
                 usort($datautfmain,function($a1,$b1){
                   $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                   return $cmp1;
                   });
                   usort($dataprcmain,function($a2,$b2){
                    $cmp2 = strcmp($b2['AMSF_YEAR'],$a2['AMSF_YEAR']);
                    return $cmp2;
                    });

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->utf_data_tgs = $datautfmain;
             $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartNine(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.FUND_SUMMARY AS FUND_SUMMARY')
                ->select(DB::raw('sum(FUND_SUMMARY.TOTALAMSF) as total'),'FUND_SUMMARY.AMSF_YEAR as AMSF_YEAR')
               ->whereIN('FUND_SUMMARY.AMSF_YEAR' , $yearArray)
               ->groupBy('FUND_SUMMARY.AMSF_YEAR')
               ->orderBy('FUND_SUMMARY.AMSF_YEAR', 'desc')
               ->get();
            //    $queryPrc = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
            //    ->select(DB::raw('sum(TGS_ENTRY.TGS_AMOUNT) as total1'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
            //    ->join('annualFee_management.TGS_ENTRY AS TGS_ENTRY', 'TGS_ENTRY.FUND_SUBMISSION_ID', '=', 'FUND_SUBMISSION.FUND_SUBMISSION_ID')
            //   ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
            //   ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=' , 'PRC')
            //   ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
            //   ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
            //   ->get();
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->total;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->amsf_data = $datautfmain;
            // $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartTen(Request $request)
    {
         try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.FUND_SUMMARY AS FUND_SUMMARY')
                ->select(DB::raw('sum(FUND_SUMMARY.ANNUAL_FEES) as total'),'FUND_SUMMARY.AMSF_YEAR as AMSF_YEAR')
               ->whereIN('FUND_SUMMARY.AMSF_YEAR' , $yearArray)
               ->groupBy('FUND_SUMMARY.AMSF_YEAR')
               ->orderBy('FUND_SUMMARY.AMSF_YEAR', 'desc')
               ->get();
               
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->total;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->amsf_data = $datautfmain;
            // $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartOne(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.AUM_ENTRY AS AUM_ENTRY')
                ->select(DB::raw('count(AUM_ENTRY.FUND_SUBMISSION_ID) as total'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
                ->join('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION', 'FUND_SUBMISSION.FUND_SUBMISSION_ID', '=', 'AUM_ENTRY.FUND_SUBMISSION_ID')
                ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
               ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
               ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
               ->get();
               
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->total;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->amsf_total_data = $datautfmain;
            // $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartTwo(Request $request)
    {
        try{
            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
                ->select(DB::raw('count(FUND_SUBMISSION.CIS_STRUCTURE) as utmctotal'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
                ->leftJoin('annualFee_management.AUM_ENTRY AS AUM_ENTRY', 'FUND_SUBMISSION.FUND_SUBMISSION_ID', '=', 'AUM_ENTRY.FUND_SUBMISSION_ID')
                ->leftJoin('funds_management.FUND_PROFILE AS FUND_PROFILE', 'FUND_PROFILE.FUND_PROFILE_ID', '=', 'FUND_SUBMISSION.FMS_ID')
                ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
                ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=','UTF')
               ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
               ->groupBy('FUND_SUBMISSION.CIS_STRUCTURE')
               ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
               ->get();
               $queryPrs = DB::table('annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION')
               ->select(DB::raw('count(FUND_SUBMISSION.CIS_STRUCTURE) as prptotal'),'FUND_SUBMISSION.AMSF_YEAR as AMSF_YEAR')
               ->leftJoin('annualFee_management.AUM_ENTRY AS AUM_ENTRY', 'FUND_SUBMISSION.FUND_SUBMISSION_ID', '=', 'AUM_ENTRY.FUND_SUBMISSION_ID')
               ->leftJoin('funds_management.FUND_PROFILE AS FUND_PROFILE', 'FUND_PROFILE.FUND_PROFILE_ID', '=', 'FUND_SUBMISSION.FMS_ID')
               ->whereIN('FUND_SUBMISSION.AMSF_YEAR' , $yearArray)
               ->where('FUND_SUBMISSION.CIS_STRUCTURE', '=','PRS')
              ->groupBy('FUND_SUBMISSION.AMSF_YEAR')
              ->groupBy('FUND_SUBMISSION.CIS_STRUCTURE')
              ->orderBy('FUND_SUBMISSION.AMSF_YEAR', 'desc')
              ->get();
             // $result = array_merge($queryUtf, $queryPrs);
            //  $result = $queryUtf->merge($queryPrs);
           //  Log::info(print_r($result));
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
            foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['total'] = $datautf->utmctotal;
                // $dt1['total1'] = $datautf->prptotal;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['total'] = 0;
                  //  $dt1['total1'] = 0;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });
              //  Log::info(print_r($queryPrs));
                foreach ($queryPrs as $datautf1) {

                    array_push($ta3, $datautf1->AMSF_YEAR);
                    $dt2['total1'] = $datautf1->prptotal;
                   // $dt1['total1'] = $datautf->prptotal;
                    $dt2['AMSF_YEAR'] = $datautf1->AMSF_YEAR;
                    array_push($dataprcmain, $dt2);
                }
                foreach($yearArray as $ta_2){
                   if(!in_array($ta_2, $ta3)){
                       $dt2['total1'] = 0;
                     //  $dt1['total1'] = 0;
                       $dt2['AMSF_YEAR'] = $ta_2;
                       array_push($dataprcmain, $dt2);
                   }
                 }
                 usort($dataprcmain,function($a2,$b2){
                   $cmp2 = strcmp($b2['AMSF_YEAR'],$a2['AMSF_YEAR']);
                   $result = Array();
                   return $cmp2;
                   });     
                   foreach ($datautfmain as $key_1 => &$value_1) {
                   // Log::info(print_r($key_1));
                    foreach ($dataprcmain as $key_1 => $value_2) {
                        if($value_1['AMSF_YEAR'] ==  $value_2['AMSF_YEAR']) {
                            $result[] = array_merge($value_1,$value_2);

                        }
                    }
            
                }
                //  Log::info(print_r($result));

            $d = new \stdClass();
            $d->amsf_data = $result;
            // $d->prc_data_tgs = $dataprcmain;
            // $d->resignation_data = $resignation_data;
            // $d->revocation_data = $revocation_data;
            http_response_code(200);
            return response([
            'message' => 'Data successfully retrieved.',
            'data' => $result,
            ]);

        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ],400);
        }
    }
   public function custom_array_merge(&$array1, &$array2) {
        $result = Array();
        foreach ($array1 as $key_1 => &$value_1) {
            Log::info(print_r($value_1));
            foreach ($array2 as $key_1 => $value_2) {
                if($value_1['name'] ==  $value_2['name']) {
                    $result[] = array_merge($value_1,$value_2);
                }
            }
    
        }
        return $result;
    }
    public function getAnnualChartThree(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.CONSULTANT_INFO AS CONSULTANT_INFO')
                ->select(DB::raw('sum(CONSULTANT_INFO.UTS_COUNT) as utstotal'),DB::raw('sum(CONSULTANT_INFO.PRS_COUNT) as prstotal'),DB::raw('sum(CONSULTANT_INFO.COMBINE_UTS_PRS_COUNT) as dualtotal'),DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE) as AMSF_YEAR'))
                ->whereIN(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'), $yearArray)
               // ->whereIN('CONSULTANT_INFO.AMSF_YEAR' , $yearArray)
               ->groupBy(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'))
              // ->groupBy('CONSULTANT_INFO.AMSF_YEAR')
              ->orderBy(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'), 'desc')
              // ->orderBy('CONSULTANT_INFO.AMSF_YEAR', 'desc')
               ->get();
               
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['utstotal'] = $datautf->utstotal;
                 $dt1['prstotal'] = $datautf->prstotal;
                 $dt1['dualtotal'] = $datautf->dualtotal;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['utstotal'] = 0.00;
                    $dt1['prstotal'] = 0.00;
                    $dt1['dualtotal'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->total_data = $datautfmain;
            // $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartFour(Request $request)
    {
        try{

            $currentDateTime =  Carbon::now();
            $previousDate = Carbon::now()->subYear(1);
            $previousDate1 = Carbon::now()->subYear(2);
            $previousYear = $previousDate->format('Y');
            $previousYear1 = $previousDate1->format('Y');
           
            $currentYear = Carbon::now()->format('Y');
           // Log::info( "currentYear ===>" . $currentYear);
            $yearArray = array($currentYear,$previousYear,$previousYear1);

            $queryUtf = DB::table('annualFee_management.CONSULTANT_INFO AS CONSULTANT_INFO')
                ->select(DB::raw('sum(CONSULTANT_INFO.COMBINE_UTS_PRS_COUNT) as dualtotal'),DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE) as AMSF_YEAR'))
                ->whereIN(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'), $yearArray)
               // ->whereIN('CONSULTANT_INFO.AMSF_YEAR' , $yearArray)
               ->groupBy(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'))
              // ->groupBy('CONSULTANT_INFO.AMSF_YEAR')
              ->orderBy(DB::raw('YEAR(CONSULTANT_INFO.LATEST_UPDATE)'), 'desc')
              // ->orderBy('CONSULTANT_INFO.AMSF_YEAR', 'desc')
               ->get();
               
               $dt =array();
               $ta1 = array();
               $datautfmain = array();
               $dt1 =array();
               $dt2 =array();
               $ta2 = array();
               $dataprcmain = array();
               $ta3 = array();
               $ta4 = array();
               foreach ($queryUtf as $datautf) {
                 array_push($ta2, $datautf->AMSF_YEAR);
                 $dt1['dualtotal'] = $datautf->dualtotal;
                 $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
                 array_push($datautfmain, $dt1);
             }
             foreach($yearArray as $ta_l){
                if(!in_array($ta_l, $ta2)){
                    $dt1['dualtotal'] = 0.00;
                    $dt1['AMSF_YEAR'] = $ta_l;
                    array_push($datautfmain, $dt1);
                }
              }
              usort($datautfmain,function($a1,$b1){
                $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
                return $cmp1;
                });

                

              // Log::info(print_r($datautfmain));

            $d = new \stdClass();
            $d->total_consultant_data = $datautfmain;
            // $d->prc_data_tgs = $dataprcmain;
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
    public function getAnnualChartFive(Request $request)
    {
        // try{

        //     $currentDateTime =  Carbon::now();
        //     $previousDate = Carbon::now()->subYear(1);
        //     $previousDate1 = Carbon::now()->subYear(2);
        //     $previousYear = $previousDate->format('Y');
        //     $previousYear1 = $previousDate1->format('Y');
           
        //     $currentYear = Carbon::now()->format('Y');
        //    // Log::info( "currentYear ===>" . $currentYear);
        //     $yearArray = array($currentYear,$previousYear,$previousYear1);

        //     $queryUtf = DB::table('annualFee_management.FUND_SUMMARY AS FUND_SUMMARY')
        //         ->select(DB::raw('sum(FUND_SUMMARY.TOTALAMSF) as total'),'FUND_SUMMARY.AMSF_YEAR as AMSF_YEAR')
        //        ->whereIN('FUND_SUMMARY.AMSF_YEAR' , $yearArray)
        //        ->groupBy('FUND_SUMMARY.AMSF_YEAR')
        //        ->orderBy('FUND_SUMMARY.AMSF_YEAR', 'desc')
        //        ->get();
               
        //        $dt =array();
        //        $ta1 = array();
        //        $datautfmain = array();
        //        $dt1 =array();
        //        $dt2 =array();
        //        $ta2 = array();
        //        $dataprcmain = array();
        //        $ta3 = array();
        //        $ta4 = array();
        //        foreach ($queryUtf as $datautf) {
        //          array_push($ta2, $datautf->AMSF_YEAR);
        //          $dt1['total'] = $datautf->total;
        //          $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
        //          array_push($datautfmain, $dt1);
        //      }
        //      foreach($yearArray as $ta_l){
        //         if(!in_array($ta_l, $ta2)){
        //             $dt1['total'] = 0.00;
        //             $dt1['AMSF_YEAR'] = $ta_l;
        //             array_push($datautfmain, $dt1);
        //         }
        //       }
        //       usort($datautfmain,function($a1,$b1){
        //         $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
        //         return $cmp1;
        //         });

                

        //       // Log::info(print_r($datautfmain));

        //     $d = new \stdClass();
        //     $d->amsf_data = $datautfmain;
        //     // $d->prc_data_tgs = $dataprcmain;
        //     // $d->resignation_data = $resignation_data;
        //     // $d->revocation_data = $revocation_data;
        //     http_response_code(200);
        //     return response([
        //     'message' => 'Data successfully retrieved.',
        //     'data' => $d,
        //     ]);

        // } catch (RequestException $r) {
        //     http_response_code(400);
        //     return response([
        //     'message' => 'Failed to retrieve data.',
        //     'errorCode' => 4103
        //     ],400);
        // }
    }
    public function getAnnualChartSix(Request $request)
    {
        // try{

        //     $currentDateTime =  Carbon::now();
        //     $previousDate = Carbon::now()->subYear(1);
        //     $previousDate1 = Carbon::now()->subYear(2);
        //     $previousYear = $previousDate->format('Y');
        //     $previousYear1 = $previousDate1->format('Y');
           
        //     $currentYear = Carbon::now()->format('Y');
        //    // Log::info( "currentYear ===>" . $currentYear);
        //     $yearArray = array($currentYear,$previousYear,$previousYear1);

        //     $queryUtf = DB::table('annualFee_management.FUND_SUMMARY AS FUND_SUMMARY')
        //         ->select(DB::raw('sum(FUND_SUMMARY.TOTALAMSF) as total'),'FUND_SUMMARY.AMSF_YEAR as AMSF_YEAR')
        //        ->whereIN('FUND_SUMMARY.AMSF_YEAR' , $yearArray)
        //        ->groupBy('FUND_SUMMARY.AMSF_YEAR')
        //        ->orderBy('FUND_SUMMARY.AMSF_YEAR', 'desc')
        //        ->get();
               
        //        $dt =array();
        //        $ta1 = array();
        //        $datautfmain = array();
        //        $dt1 =array();
        //        $dt2 =array();
        //        $ta2 = array();
        //        $dataprcmain = array();
        //        $ta3 = array();
        //        $ta4 = array();
        //        foreach ($queryUtf as $datautf) {
        //          array_push($ta2, $datautf->AMSF_YEAR);
        //          $dt1['total'] = $datautf->total;
        //          $dt1['AMSF_YEAR'] = $datautf->AMSF_YEAR;
        //          array_push($datautfmain, $dt1);
        //      }
        //      foreach($yearArray as $ta_l){
        //         if(!in_array($ta_l, $ta2)){
        //             $dt1['total'] = 0.00;
        //             $dt1['AMSF_YEAR'] = $ta_l;
        //             array_push($datautfmain, $dt1);
        //         }
        //       }
        //       usort($datautfmain,function($a1,$b1){
        //         $cmp1 = strcmp($b1['AMSF_YEAR'],$a1['AMSF_YEAR']);
        //         return $cmp1;
        //         });

                

        //       // Log::info(print_r($datautfmain));

        //     $d = new \stdClass();
        //     $d->amsf_data = $datautfmain;
        //     // $d->prc_data_tgs = $dataprcmain;
        //     // $d->resignation_data = $resignation_data;
        //     // $d->revocation_data = $revocation_data;
        //     http_response_code(200);
        //     return response([
        //     'message' => 'Data successfully retrieved.',
        //     'data' => $d,
        //     ]);

        // } catch (RequestException $r) {
        //     http_response_code(400);
        //     return response([
        //     'message' => 'Failed to retrieve data.',
        //     'errorCode' => 4103
        //     ],400);
        // }
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
        $access_user_group_type = $request->SETTING_USER_TYPE_GROUP;
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
                            $data =DashboardAnnualDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardAnnualDisplaySetting;
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
                            $data->SETTING_USER_TYPE_GROUP = $access_user_group_type;
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
            $data = DashboardAnnualDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

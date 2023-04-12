<?php

namespace App\Http\Controllers;

use App\Models\DashboardFinanceDisplaySetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardFinanceDisplaySettingController extends Controller
{
    public function get(Request $request)
    {
        try{

            // $data_distributor = DashboardFinanceDisplaySetting::where('SETTING_USER_ID',$request->SETTING_USER_ID)->where('SETTING_USER_TYPE',$request->SETTING_USER_TYPE)->where('SETTING_USER_GROUP',$request->SETTING_USER_GROUP)->first();
            $data_distributor = DashboardFinanceDisplaySetting::where('ACCESS_USER_DIVISION',$request->ACCESS_USER_DIVISION)
            ->where('ACCESS_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->where('ACCESS_USER_GROUP',$request->SETTING_USER_GROUP)
            //->orWhere('SUPER_USER_DEPARTMENT',$request->ACCESS_USER_DEPARTMENT)
            ->first();
            if($data_distributor){
               // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
                $data= DB::table('admin_management.DASHBOARD_FINANCE_DISPLAY_SETTING AS DASHBOARD_FINANCE_DISPLAY_SETTING')
                ->select('DASHBOARD_FINANCE_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DASHBOARD_FINANCE_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE','DASHBOARD_CHART_TYPE.CHART_NAME','DASHBOARd_MAIN_SETTING.DASHBOARD_LIST','DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION','DASHBOARd_MAIN_SETTING.GRAPH_ID')
                ->leftJoin('admin_management.DASHBOARD_CHART_TYPE AS DASHBOARD_CHART_TYPE', 'DASHBOARD_CHART_TYPE.CHART_ID', '=', 'DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_CHART_ID')
                ->leftJoin('admin_management.DASHBOARd_MAIN_SETTING AS DASHBOARd_MAIN_SETTING', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID', '=', 'DASHBOARD_FINANCE_DISPLAY_SETTING.DASHBOARD_SETTING_ID')
                ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
               //  ->orWhere('DASHBOARD_FINANCE_DISPLAY_SETTING.SUPER_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                // ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
                // ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
                // ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_USER_GROUP', '=' , $request->SETTING_USER_GROUP)
                ->orderBy('DASHBOARD_FINANCE_DISPLAY_SETTING.SETTING_INDEX', 'asc')
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
    public function getChartSettingTwo(Request $request)
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
    public function getChartSettingSeven(Request $request)
    {
        try{

            $data = DB::table('consultant_management.CONSULTANT AS CONSULTANT')
            ->select('CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME','CONSULTANT_EXAMINATION.CONSULTANT_ID AS CONSULTANT_ID','CONSULTANT_SCHEME.FEE_AMOUNT AS FEE_AMOUNT','CONSULTANT_EXAM_TYPE.EXAM_TYPE_NAME AS EXAM_TYPE_NAME')
            ->Join('consultant_management.CONSULTANT_EXAMINATION AS CONSULTANT_EXAMINATION','CONSULTANT_EXAMINATION.CONSULTANT_ID', '=', 'CONSULTANT.CONSULTANT_ID')
            ->leftJoin('consultant_management.CONSULTANT_SCHEME AS CONSULTANT_SCHEME','CONSULTANT_SCHEME.CONSULTANT_SCHEME_ID', '=', 'CONSULTANT_EXAMINATION.CONSULTANT_SCHEME_ID')
            ->leftJoin('admin_management.CONSULTANT_EXAM_TYPE AS CONSULTANT_EXAM_TYPE','CONSULTANT_EXAM_TYPE.CONSULTANT_EXAM_TYPE_ID', '=', 'CONSULTANT_EXAMINATION.EXAM_TYPE')
            ->whereIN('CONSULTANT_EXAMINATION.EXAM_TYPE', [1,2])
            ->groupBy('CONSULTANT_ID')
            ->orderBy('CONSULTANT_EXAMINATION.CREATE_TIMESTAMP', 'desc')
           // ->take(25)
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
        $user_group=$request->usergroup;
        $access_user_division = $request->ACCESS_USER_DIVISION;
        $access_user_departrment = $request->ACCESS_USER_DEPARTMENT;
        $super_user_department = 7;
        $access_user_group = $request->ACCESS_USER_GROUP;

            try {
                foreach ($req as $r) {
                        if(isset($r['setting_setup']['DISPLAY_SETTING_ID']))
                        {
                            $data =DashboardFinanceDisplaySetting::find($r['setting_setup']['DISPLAY_SETTING_ID']);
                        }
                        else{
                            $data = new DashboardFinanceDisplaySetting;
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
                            $data->save();
                }
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
            $data = DashboardFinanceDisplaySetting::find($request->DISPLAY_SETTING_ID);
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

<?php

namespace App\Http\Controllers;

use App\Models\DashboardMainSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
class DashboardMainSettingController extends Controller
{
    public function getDistributorDashboardSetting(Request $request)
    {
        // Log::info( "User ID ===>" . $request->SETTING_USER_ID);
        try {
            $data_distributor_setting= DB::table('admin_management.DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING  AS DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING')
            ->where('DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
            ->where('DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            ->where('DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->where('DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING.SETTING_USER_GROUP', '=' , $request->DASHBOARD_SUB_TYPE)
            ->get();

        //     $query = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING');

        //            $query->select('DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID AS DASHBOARD_MAIN_ID', 'DASHBOARd_MAIN_SETTING.DASHBOARD_LIST AS DASHBOARD_LIST', 'DASHBOARd_MAIN_SETTING.DASHBOARD_DESCRIPTION AS DASHBOARD_DESCRIPTION','DISTRIBUTOR_DISPLAY_SETTING.SETTING_USER_ID AS SETTING_USER_ID','DISTRIBUTOR_DISPLAY_SETTING.DISPLAY_SETTING_ID AS DISPLAY_SETTING_ID','DISTRIBUTOR_DISPLAY_SETTING.SETTING_CHART_ID AS SETTING_CHART_ID','DISTRIBUTOR_DISPLAY_SETTING.SETTING_INDEX AS SETTING_INDEX','DISTRIBUTOR_DISPLAY_SETTING.SETTING_STATUS AS SETTING_STATUS','DISTRIBUTOR_DISPLAY_SETTING.DISPLAY_SETTING_STYLE AS DISPLAY_SETTING_STYLE')
        //            ->leftJoin('distributor_management.DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING AS DISTRIBUTOR_DISPLAY_SETTING', 'DISTRIBUTOR_DISPLAY_SETTING.DASHBOARD_SETTING_ID', '=', 'DASHBOARd_MAIN_SETTING.DASHBOARD_MAIN_ID');
        //   // }
        //     $data = $query->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','DISTRIBUTOR')
        //            ->get();
        $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')
        ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','DISTRIBUTOR')
        ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_SUB_TYPE', '=' , $request->DASHBOARD_SUB_TYPE)
        ->get();

        $data2 = array();
        $obj = new \stdClass();
        foreach ($data as $d) {
             $d->setting_setup = $obj;
             if($data_distributor_setting){
                 $pdata = array();
                 foreach ($data_distributor_setting as $cpd) {
                     if($d->DASHBOARD_MAIN_ID == $cpd->DASHBOARD_SETTING_ID){
                         array_push($pdata, $cpd);
                         $d->setting_setup = $cpd;
                     }
                 }
             }
             array_push($data2, $d);
         }

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data2
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }
    public function getcpdDashboardSetting(Request $request)
    {
        try {
            $data_cpd_setting= DB::table('admin_management.DASHBOARD_CPD_DISPLAY_SETTING  AS DASHBOARD_CPD_DISPLAY_SETTING')
            ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
            ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            ->where('DASHBOARD_CPD_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','CPD')->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cpd_setting){
                    $pdata = array();
                    foreach ($data_cpd_setting as $cpd) {
                        if($d->DASHBOARD_MAIN_ID == $cpd->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cpd);
                            $d->setting_setup = $cpd;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getcasDashboardSetting(Request $request)
    {
        try {
            $data_cas_setting= DB::table('admin_management.DASHBOARD_CAS_DISPLAY_SETTING  AS DASHBOARD_CAS_DISPLAY_SETTING')
             ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
             ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
             ->where('DASHBOARD_CAS_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','CAS')->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cas_setting){
                    $pdata = array();
                    foreach ($data_cas_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getFmsDashboardSetting(Request $request)
    {
        try {
            $SETTING_USER_DEPARTMENT = $request->SETTING_USER_DEPARTMENT;
            if($request->SETTING_USER_TYPE_GROUP == 2)
            {
                $takedata = 2;
            }
            else{
                $takedata = 1;
            }
        //     if($SETTING_USER_DEPARTMENT == 7)
        //     {
        //     $data_cas_setting= DB::table('admin_management.DASHBOARD_FMS_DISPLAY_SETTING  AS DASHBOARD_FMS_DISPLAY_SETTING')
        //    // ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
        //   //  ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
        //     ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_GROUP', '=' , 17)
        //     ->get();

        //     $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','FMS')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_SUB_TYPE','=',1)->get();
        //     }
        //     else{
                $data_cas_setting= DB::table('admin_management.DASHBOARD_FMS_DISPLAY_SETTING  AS DASHBOARD_FMS_DISPLAY_SETTING')
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP', '=' , $request->SETTING_USER_TYPE_GROUP)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
                ->where('DASHBOARD_FMS_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
                ->get();

                $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','FMS')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_SUB_TYPE','=',$takedata)->get();
            //}

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cas_setting){
                    $pdata = array();
                    foreach ($data_cas_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getConsultantDashboardSetting(Request $request)
    {
        try {
            // if($request->SETTING_USER_GROUP == 2)
            // {
            //     $takedata = 2;
            // }
            // else{
            //     $takedata = 1;
            // }
            // $data_cas_setting= DB::table('admin_management.DASHBOARD_CONSULTANT_DISPLAY_SETTING  AS DASHBOARD_CONSULTANT_DISPLAY_SETTING')
            // ->get();
            $data_cas_setting= DB::table('admin_management.DASHBOARD_CONSULTANT_DISPLAY_SETTING  AS DASHBOARD_CONSULTANT_DISPLAY_SETTING')
             ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
             ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
             ->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
             //->where('DASHBOARD_CONSULTANT_DISPLAY_SETTING.ACCESS_USER_ROLE', '=' , $request->ACCESS_USER_ROLE)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','CONSULTANT')->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cas_setting){
                    $pdata = array();
                    foreach ($data_cas_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getFinanceDashboardSetting(Request $request)
    {
        try {
            // if($request->SETTING_USER_GROUP == 2)
            // {
            //     $takedata = 2;
            // }
            // else{
            //     $takedata = 1;
            // }
            $data_cas_setting= DB::table('admin_management.DASHBOARD_FINANCE_DISPLAY_SETTING  AS DASHBOARD_FINANCE_DISPLAY_SETTING')
            ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
            ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            ->where('DASHBOARD_FINANCE_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','FINANCE')->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cas_setting){
                    $pdata = array();
                    foreach ($data_cas_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getAnnualDashboardSetting(Request $request)
    {
        try {
            // if($request->SETTING_USER_GROUP == 2)
            // {
            //     $takedata = 2;
            // }
            // else{
            //     $takedata = 1;
            // }
            $data_cas_setting= DB::table('admin_management.DASHBOARD_ANNUAL_DISPLAY_SETTING  AS DASHBOARD_ANNUAL_DISPLAY_SETTING')
            ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.SETTING_USER_TYPE_GROUP', '=' , $request->SETTING_USER_TYPE_GROUP)
            ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
            ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            ->where('DASHBOARD_ANNUAL_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')
                    ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','ANNUAL')
                    ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_SUB_TYPE', '=' , $request->SETTING_USER_TYPE_GROUP)
                    ->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_cas_setting){
                    $pdata = array();
                    foreach ($data_cas_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getAdminDashboardSetting(Request $request)
    {
        try {
            $data_admin_setting= DB::table('admin_management.DASHBOARD_ADMIN_DISPLAY_SETTING  AS DASHBOARD_ADMIN_DISPLAY_SETTING')
            ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_DIVISION', '=' , $request->ACCESS_USER_DIVISION)
            ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_DEPARTMENT', '=' , $request->ACCESS_USER_DEPARTMENT)
            ->where('DASHBOARD_ADMIN_DISPLAY_SETTING.ACCESS_USER_GROUP', '=' , $request->ACCESS_USER_GROUP)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','=','ADMIN')->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_admin_setting){
                    $pdata = array();
                    foreach ($data_admin_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }
    public function getAllDistributor(Request $request)
    {
        try {
            Log::info( "List ===>" . $request->DASHBOARD_TYPE);
			$data = DashboardMainSetting::where('DASHBOARD_TYPE',$request->DASHBOARD_TYPE)->get();

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
            ],400);
        }
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'DASHBOARD_LIST' => 'string|nullable',
        'DASHBOARD_DESCRIPTION' => 'string|nullable',
        ]);

        if ($validator->fails()) {
        http_response_code(400);
        return response([
        'message' => 'Data validation error.',
        'errorCode' => 4106
        ],400);
        }

        try {
        $lastChartId = DashboardMainSetting::where('DASHBOARD_TYPE',$request->DASHBOARD_TYPE)->max('GRAPH_ID');
        //create function
        $data = new DashboardMainSetting;
        $data->DASHBOARD_TYPE = strtoupper($request->DASHBOARD_TYPE);
        $data->DASHBOARD_SUB_TYPE = $request->DASHBOARD_SUB_TYPE;
        $data->DASHBOARD_LIST = strtoupper($request->DASHBOARD_LIST);
        $data->DASHBOARD_DESCRIPTION = strtoupper($request->DASHBOARD_DESCRIPTION);
        $data->GRAPH_ID = $lastChartId+1;
        $data->save();

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
    public function getById(Request $request)
    {
        try {
			$data = DashboardMainSetting::find($request->DASHBOARD_MAIN_ID);

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
            ],400);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'DASHBOARD_LIST' => 'string|nullable',
        'DASHBOARD_DESCRIPTION' => 'string|nullable',
        ]);

        if ($validator->fails()) {
        http_response_code(400);
        return response([
        'message' => 'Data validation error.',
        'errorCode' => 4106
        ],400);
        }

        try {
        //create function
        $data = DashboardMainSetting::find($request->DASHBOARD_MAIN_ID);
        $data->DASHBOARD_LIST = strtoupper($request->DASHBOARD_LIST);
        $data->DASHBOARD_DESCRIPTION = strtoupper($request->DASHBOARD_DESCRIPTION);
        $data->DASHBOARD_SUB_TYPE = $request->DASHBOARD_SUB_TYPE;
        $data->save();

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
        try {
            $data_distributor_setting= DB::table('distributor_management.DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING  AS DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING')->where('DASHBOARD_DISTRIBUTOR_DISPLAY_SETTING.DASHBOARD_SETTING_ID','=',$request->DASHBOARD_MAIN_ID)->first();
            if(!$data_distributor_setting){
                $data = DashboardMainSetting::find($request->DASHBOARD_MAIN_ID);
                $data->delete();


                http_response_code(200);
                return response([
                'message' => 'Data successfully deleted',
                ]);
            }
            else{
                http_response_code(400);
                return response([
                    'message' => 'Failed to delete data',
                    'errorCode' =>  4100
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete data',
                'errorCode' =>  $th
            ]);
        }
    }

    public function getMainDashboardSetting(Request $request)
    {
        try {
            $data_admin_setting= DB::table('admin_management.DASHBOARD_MAIN_DISPLAY_SETTING  AS DASHBOARD_MAIN_DISPLAY_SETTING')
             ->where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_ID', '=' , $request->SETTING_USER_ID)
             ->where('DASHBOARD_MAIN_DISPLAY_SETTING.SETTING_USER_TYPE', '=' , $request->SETTING_USER_TYPE)
            ->get();

            $data = DB::table('admin_management.DASHBOARd_MAIN_SETTING  AS DASHBOARd_MAIN_SETTING')
            ->where('DASHBOARd_MAIN_SETTING.DASHBOARD_TYPE','!=','ADMIN')
            ->orderby('DASHBOARD_LIST','asc')
            ->get();

           $data2 = array();
           $obj = new \stdClass();
           foreach ($data as $d) {
                $d->setting_setup = $obj;
                if($data_admin_setting){
                    $pdata = array();
                    foreach ($data_admin_setting as $cas) {
                        if($d->DASHBOARD_MAIN_ID == $cas->DASHBOARD_SETTING_ID){
                            array_push($pdata, $cas);
                            $d->setting_setup = $cas;
                        }
                    }
                }
                array_push($data2, $d);
            }
            //Example, how to merge 2 collections
            //$data2 = $data->merge($data_cpd_setting);
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
            ],400);
        }
    }

}

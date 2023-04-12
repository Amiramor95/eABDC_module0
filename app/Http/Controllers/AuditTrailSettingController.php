<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuditTrailSettingController extends Controller
{
    public function get(Request $request)
    {
       
    }
    public function getAllMainModule(Request $request)
    {
        try {
            $data = DB::table('admin_management.MAIN_MODULE AS MAIN_MODULE')
            ->select('*')
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
            ],400);
        }
    }


    public function getAuditTrailData(Request $request)
    {
        
        try {
              Log::info("Request=".$request->START_DATE);
              //$data= array();
              $start = $request->START_DATE;
              $end = $request->END_DATE;
              Log::info("date=".$start);
              if($request->MODULE_TYPE == 1){
                $data = DB::table('admin_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
               // ->where('AUDIT_TRAILS.NEW_VALUES', '!=',[])
                ->get();
              }
              if($request->MODULE_TYPE == 2){
                $data = DB::table('distributor_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 3){
                $data = DB::table('consultant_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 4){
                $data = DB::table('funds_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 5){
                $data = DB::table('finance_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 6){
                $data = DB::table('consultantAlert_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 7){
                $data = DB::table('annualFee_management.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
              if($request->MODULE_TYPE == 8){
                $data = DB::table('exam_booking.AUDIT_TRAILS AS AUDIT_TRAILS')
                ->select('AUDIT_TRAILS.AUDIT_ID AS AUDIT_ID','AUDIT_TRAILS.EVENT AS EVENT','AUDIT_TRAILS.NEW_VALUES AS NEW_VALUES','AUDIT_TRAILS.OLD_VALUES AS OLD_VALUES','AUDIT_TRAILS.UPDATED_AT AS UPDATED_AT')
                ->whereBetween('AUDIT_TRAILS.UPDATED_AT', [$start, $end])
                ->get();
              }
                foreach($data as $element){
                $tr = "";
                $tr1 = "";
                
                //     Log::info("date=".$element->NEW_VALUES);
                //  //  dd()
                 if($element->NEW_VALUES != [])
                 {
                    $jsondata = json_decode($element->NEW_VALUES,true) ?? [];
                    foreach($jsondata as $attribute => $value)
                    {
                        $tr .= "<tr><td><b>" .$attribute . "</b></td><td>".$value ."</td></tr>";
                    }
                   
                   $table = '<table class="table table-bordered table-hover" style="width:100%;display:inline-block">'. $tr .'</table>';
                 
                 }
                 if($element->OLD_VALUES != [])
                 {
                    $jsondata1 = json_decode($element->OLD_VALUES,true) ?? [];
                    foreach($jsondata1 as $attribute1 => $value1)
                    {
                        $tr1 .= "<tr><td><b>" .$attribute1 . "</b></td><td>".$value1 ."</td></tr>";
                    }
                   
                   $table1 = '<table class="table table-bordered table-hover" style="width:100%;display:inline-block">'. $tr1 .'</table>';
                 
                 }

                $element->UPDATED_AT =  date('d/m/Y', strtotime($element->UPDATED_AT));
                $element->NEW_VALUES =  $table;
                $element->OLD_VALUES =  $table1;
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
            ],400);
        }
    }

}

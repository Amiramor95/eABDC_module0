<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\FinanceAccCode;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class FinanceAccCodeController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = FinanceAccCode::all();

            $sql = "SELECT FA.FINANCE_ACC_CODE_ID,
                           FA.ACC_CODE, 
                           FA.REF_NUMBER, 
                           FA.FINANCE_ACC_CODE_NAME, 
                           FAC.CODE_TYPE AS CODE_TYPE,
                    CASE WHEN FA.STATUS = 1 THEN  'ACTIVE' 
                     WHEN FA.STATUS = 0 THEN 'INACTIVE' END AS STATUS 
                  FROM admin_management.FINANCE_ACC_CODE AS FA 
                  LEFT JOIN admin_management.FINANCE_ACC_CODE_TYPE AS FAC ON FAC.FINANCE_ACC_CODE_TYPE_ID = FA.FINANCE_ACC_CODE_TYPE_ID
                  ORDER BY STATUS ASC, FA.FINANCE_ACC_CODE_ID DESC  
                  
            ";

            $data = DB::select($sql);
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
            ], 400);
        }
    }

    public function getAccCodeType(Request $request)
    {
        try {
            $data = DB::table('admin_management.FINANCE_ACC_CODE_TYPE')
                ->select('*')
                ->orderby('CODE_TYPE', 'ASC')
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
            ], 400);
        }
    }
    public function getAccCodeName(Request $request)
    {
        try {
            $data = DB::table('admin_management.FINANCE_ACC_CODE_NAME')
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
            ], 400);
        }
    }
    public function getAll()
    {
        try {
            $data = DB::table('admin_management.FINANCE_ACC_CODE AS FIN_CODE')
                ->select(
                    'FIN_CODE.ACC_CODE',
                    'FIN_CODE.STATUS',
                    'CODE_TYPE.CODE_TYPE AS CODE_TYPE',
                    'FIN_CODE.REF_NUMBER',
                    'FIN_CODE.FINANCE_ACC_CODE_NAME',
                    DB::raw("CASE WHEN FIN_CODE.STATUS=1 THEN 'ACTIVE' 
            WHEN FIN_CODE.STATUS=0 THEN 'INACTIVE' END AS STATUS2")
                )
                ->join('admin_management.FINANCE_ACC_CODE_TYPE AS CODE_TYPE', 'CODE_TYPE.FINANCE_ACC_CODE_TYPE_ID', '=', 'FIN_CODE.FINANCE_ACC_CODE_TYPE_ID')
                ->orderBy('FIN_CODE.STATUS', 'DESC')
                ->get();

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
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ACC_CODE' => 'required|string', //3001
            'ACC_CODE' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            //create function
            // dd($request->ACC_CODE);

            $test = DB::table('admin_management.FINANCE_ACC_CODE AS FIN_CODE')
                ->select('*')
                ->join('admin_management.FINANCE_ACC_CODE_TYPE AS CODE_TYPE', 'CODE_TYPE.FINANCE_ACC_CODE_TYPE_ID', '=', 'FIN_CODE.FINANCE_ACC_CODE_TYPE_ID')
                ->where('FIN_CODE.FINANCE_ACC_CODE_TYPE_ID', $request->FINANCE_ACC_CODE_TYPE_ID)
                ->get();

            // dd($test);

            if ($test = null) {
                $data = new FinanceAccCode;
                $data->ACC_CODE = strtoupper($request->ACC_CODE);
                $data->REF_NUMBER = $request->REF_NUMBER;
                $data->FINANCE_ACC_CODE_TYPE_ID = $request->FINANCE_ACC_CODE_TYPE_ID;
                $data->FINANCE_ACC_CODE_NAME = $request->FINANCE_ACC_CODE_NAME;
                $data->STATUS = $request->STATUS;
                $data->save();

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.'
                ]);
            } else {
                // dd('test');
                $updatedata = DB::table('admin_management.FINANCE_ACC_CODE AS FIN_CODE')
                    ->select('*')
                    ->join('admin_management.FINANCE_ACC_CODE_TYPE AS CODE_TYPE', 'CODE_TYPE.FINANCE_ACC_CODE_TYPE_ID', '=', 'FIN_CODE.FINANCE_ACC_CODE_TYPE_ID')
                    ->where('FIN_CODE.FINANCE_ACC_CODE_TYPE_ID', $request->FINANCE_ACC_CODE_TYPE_ID)
                    ->update(['FIN_CODE.STATUS' => 0]);

                $data = new FinanceAccCode;
                $data->ACC_CODE = strtoupper($request->ACC_CODE);
                $data->REF_NUMBER = $request->REF_NUMBER;
                $data->FINANCE_ACC_CODE_TYPE_ID = $request->FINANCE_ACC_CODE_TYPE_ID;
                $data->FINANCE_ACC_CODE_NAME = $request->FINANCE_ACC_CODE_NAME;
                $data->STATUS = $request->STATUS;
                $data->save();

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.'
                ]);
            }
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ], 400);
        }
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ACC_CODE' => 'required|string', //3001
            'ACC_NAME' => 'required|string' //receivable 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => ''
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ACC_CODE' => 'nullable|string', //3001
            'ACC_NAME' => 'nullable|string' //receivable
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            $data = FinanceAccCode::where($request->FINANCE_ACC_CODE_ID);
            $data->ACC_CODE = strtoupper($request->ACC_CODE);
            $data->ACC_NAME = strtoupper($request->ACC_NAME);
            $data->save();

            http_response_code(200);
            return response([
                'message' => ''
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = FinanceAccCode::find($request->FINANCE_ACC_CODE_ID);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ACC_CODE' => 'required|string', //3001
            'ACC_NAME' => 'required|string' //receivable
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => 'Filtered data successfully retrieved.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ], 400);
        }
    }
}

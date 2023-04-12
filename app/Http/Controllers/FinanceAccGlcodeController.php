<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\FinanceAccGlcode;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class FinanceAccGlcodeController extends Controller
{
    public function getAll()
    {
        try {
            $data = DB::table('admin_management.FINANCE_CODE AS A')
                ->select(
                    'A.FIN_DISTRIBUTOR_NAME',
                    'A.FIN_CODE',
                    'C.DIST_NAME AS DISTNAME',
                    'C.DIST_CODE AS DIST_CODE',
                    DB::raw("CASE WHEN A.STATUS=1 THEN 'ACTIVE' 
                        WHEN A.STATUS=0 THEN 'INACTIVE' END AS STATUS2")
                )
                ->leftJoin('distributor_management.DISTRIBUTOR AS C', 'A.DIST_ID', '=', 'C.DISTRIBUTOR_ID')
                ->orderBy('A.STATUS', 'DESC')
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



    public function get(Request $request)
    {
        try {
            $data = DB::table('admin_management.FINANCE_ACC_GLCODE AS A')
                ->select('*', ' A.GL_CODE AS GL', 'B.ACC_CODE AS ACCCODE', 'B.ACC_NAME AS ACCNAME', 'C.DIST_NAME AS DISTNAME')
                ->leftJoin('admin_management.FINANCE_ACC_CODE AS B', 'B.FINANCE_ACC_CODE_ID', '=', 'A.FINANCE_ACC_CODE_ID')
                ->leftJoin('distributor_management.DISTRIBUTOR AS C', 'A.DIST_ID', '=', 'C.DISTRIBUTOR_ID')

                ->first();

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

    public function getAllDistributor()
    {
        try {
            $distributor = DB::table('distributor_management.DISTRIBUTOR AS DISTRIBUTOR')
                ->select('DISTRIBUTOR.DISTRIBUTOR_ID AS DIST_ID', 'DISTRIBUTOR.DIST_NAME AS DIST_NAME')
                ->orderby('DISTRIBUTOR.DIST_NAME')
                ->get();



            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $distributor,
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103,
            ], 400);
        }
    }

    public function getCodeTable(Request $request)
    {
        try {
            $data = DB::table('FINANCE_CODE_TABLE')
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

    public function create(Request $request)
    {
        try {

            $test = DB::table('admin_management.FINANCE_CODE AS A')
                ->select('*')
                ->where('A.DIST_ID', $request->DIST_ID)
                ->get();


            if ($test = null) {
                $data = new FinanceAccGlcode;
                $data->FIN_CODE = strtoupper($request->FIN_CODE);
                $data->DIST_ID = $request->DIST_ID;
                $data->STATUS = $request->STATUS;
                $data->save();

                http_response_code(200);
                return response([
                    'message' => 'Data successfully updated.'
                ]);
            } else {
                $updatedata = DB::table('admin_management.FINANCE_CODE AS A')
                    ->select('*')
                    ->where('A.DIST_ID', $request->DIST_ID)
                    ->update(['A.STATUS' => 0]);

                $data = new FinanceAccGlcode;
                $data->FIN_CODE = strtoupper($request->FIN_CODE);
                $data->DIST_ID = $request->DIST_ID;
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
            'FINANCE_ACC_CODE_ID' => 'required|integer',
            'DIST_ID' => 'required|integer',
            'GL_CODE' => 'required|string'
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FINANCE_ACC_CODE_ID' => 'required|integer',
            'DIST_ID' => 'required|integer',
            'GL_CODE' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            $data = FinanceAccGlcode::where('id', $id)->first();
            $data->TEST = $request->TEST; //nama column
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
            $data = FinanceAccGlcode::find($request->FINANCE_ACC_GLCODE_ID);
            $data->delete();


            http_response_code(200);
            return response([
                'message' => 'Department successfully deleted',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete Department',
                'errorCode' =>  4102
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FINANCE_ACC_CODE_ID' => 'required|integer',
            'DIST_ID' => 'required|integer',
            'GL_CODE' => 'required|string'
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

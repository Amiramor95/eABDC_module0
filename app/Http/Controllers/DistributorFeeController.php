<?php

namespace App\Http\Controllers;

use App\Models\DistributorFee;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class DistributorFeeController extends Controller
{
    public function getDistFeeByIDType (Request $request)
    {
        //return $request->all();
        try{
            DB::enableQueryLog();
            $dataFee = DB::table('admin_management.DISTRIBUTOR_FEE AS DIST_FEE')
            ->select('TOTAL_AMOUNT_APPLICATION','DIST_FEE.DIST_TYPE_ID');
            if($request->DIST_FINANCIAL_INSTITUTION == 1 && ($request->DIST_TYPE_ID == 4 || $request->DIST_TYPE_ID == 5)){
                $dataFee = $dataFee->where('DIST_FEE.DIST_TYPE_ID',5);
            }else if($request->DIST_FINANCIAL_INSTITUTION == 2 && ($request->DIST_TYPE_ID == 4 || $request->DIST_TYPE_ID == 5)){
                $dataFee = $dataFee->where('DIST_FEE.DIST_TYPE_ID', 4);
            }else{
                $dataFee = $dataFee->where('DIST_FEE.DIST_TYPE_ID', '=', $request->DIST_TYPE_ID);
            }
            $dataFee = $dataFee->first();
            //return DB::getQueryLog();
            ($dataFee) ? $data = $dataFee->TOTAL_AMOUNT_APPLICATION : $data = 00;
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
    public function get(Request $request)
    {
        try {
            $data = DistributorFee::select('*')
                ->leftJoin('DISTRIBUTOR_TYPE AS DIST_TYPE', 'DIST_TYPE.DISTRIBUTOR_TYPE_ID', '=', 'DISTRIBUTOR_FEE.DIST_TYPE_ID')
                ->find($request->DISTRIBUTOR_FEE_ID);

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

    public function getDistributor(Request $request)
    {
        try {
            $data = DB::table('DISTRIBUTOR_TYPE')
            ->select('DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID', 'DISTRIBUTOR_TYPE.DIST_TYPE_NAME')
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

    public function getAll()
    {
        try {
            // $data = DistributorFee::all();
            $data = DB::table('DISTRIBUTOR_FEE AS FEE')
            ->select('*', 'DIST_TYPE.DIST_TYPE_NAME')
            ->leftJoin('DISTRIBUTOR_TYPE AS DIST_TYPE', 'DIST_TYPE.DISTRIBUTOR_TYPE_ID', '=', 'FEE.DIST_TYPE_ID')
            ->get();

            foreach($data as $element){
                $element->FEE_START_DATE = date('d-M-Y', strtotime($element->FEE_START_DATE));
                $element->FEE_END_DATE = date('d-M-Y', strtotime($element->FEE_END_DATE));
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

    public function create(Request $request)
    {
        //return $request->all();

        // Server validation
        $validator = Validator::make($request->all(), [
			'DIST_TYPE_ID' => 'required|integer',
			'APPLICATION_FEE' => 'required|integer',
			'TAX_APPLICATION_FEE' => 'required|integer',
			'TOTAL_AMOUNT_APPLICATION' => 'required|integer',
			'ANNUAL_FEE' => 'required|integer',
			'TAX_ANNUAL_FEE' => 'required|integer',
            'TOTAL_AMOUNT_ANNUAL_FEE' => 'required|integer',
            'FEE_START_DATE' => 'required|string',
            'FEE_END_DATE' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new DistributorFee;
            $data->DIST_TYPE_ID = $request->DIST_TYPE_ID;
            $data->APPLICATION_FEE = $request->APPLICATION_FEE;
            $data->TAX_APPLICATION_FEE = $request->TAX_APPLICATION_FEE;
            $data->TOTAL_AMOUNT_APPLICATION = $request->TOTAL_AMOUNT_APPLICATION;
            $data->ANNUAL_FEE = $request->ANNUAL_FEE;
            $data->TAX_ANNUAL_FEE = $request->TAX_ANNUAL_FEE;
            $data->TOTAL_AMOUNT_ANNUAL_FEE = $request->TOTAL_AMOUNT_ANNUAL_FEE;
            $data->FEE_START_DATE = $request->FEE_START_DATE;
            $data->FEE_END_DATE = $request->FEE_END_DATE;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ //fresh
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
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
            ],400);
        }
    }

    public function update(Request $request)
    {
        //return $request->all();
        // Server validation
        $validator = Validator::make($request->all(), [
			'DIST_TYPE_ID' => 'required|integer',
			'APPLICATION_FEE' => 'required|integer',
			'TAX_APPLICATION_FEE' => 'required|integer',
			'TOTAL_AMOUNT_APPLICATION' => 'required|integer',
			'ANNUAL_FEE' => 'required|integer',
			'TAX_ANNUAL_FEE' => 'required|integer',
            'TOTAL_AMOUNT_ANNUAL_FEE' => 'required|integer',
            'FEE_START_DATE' => 'required|string',
            'FEE_END_DATE' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
                'error' => $validator->errors()->first()
            ],400);
        }

        try {
            $data = DistributorFee::find($request->DISTRIBUTOR_FEE_ID);
            $data->DIST_TYPE_ID = $request->DIST_TYPE_ID;
            $data->APPLICATION_FEE = $request->APPLICATION_FEE;
            $data->TAX_APPLICATION_FEE = $request->TAX_APPLICATION_FEE;
            $data->TOTAL_AMOUNT_APPLICATION = $request->TOTAL_AMOUNT_APPLICATION;
            $data->ANNUAL_FEE = $request->ANNUAL_FEE;
            $data->TAX_ANNUAL_FEE = $request->TAX_ANNUAL_FEE;
            $data->TOTAL_AMOUNT_ANNUAL_FEE = $request->TOTAL_AMOUNT_ANNUAL_FEE;
            $data->FEE_START_DATE = $request->FEE_START_DATE;
            $data->FEE_END_DATE = $request->FEE_END_DATE;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ],400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = DistributorFee::find($request->DISTRIBUTOR_FEE_ID);
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
            ],400);
        }
    }

    public function filter(Request $request)
    {
        try {
            // $data = ConsultantFee::all();
            $start = $request->START_DATE;
            $end = $request->END_DATE;
            $data = DB::table('DISTRIBUTOR_FEE AS FEE')
            ->select('*', 'DIST_TYPE.DIST_TYPE_NAME')
            ->leftJoin('DISTRIBUTOR_TYPE AS DIST_TYPE', 'DIST_TYPE.DISTRIBUTOR_TYPE_ID', '=', 'FEE.DIST_TYPE_ID')
            ->where('FEE.FEE_START_DATE','>=',$start)
            ->where('FEE.FEE_END_DATE','<=',$end)
            ->get();

            foreach($data as $element){
                $element->FEE_START_DATE = date('d-M-Y', strtotime($element->FEE_START_DATE));
                $element->FEE_END_DATE = date('d-M-Y', strtotime($element->FEE_END_DATE));
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

<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\AnnualFeeInvoice;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AnnualFeeInvoiceController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = AnnualFeeInvoice::find($request->ANNUAL_FEE_INVOICE_ID);

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
            $data = AnnualFeeInvoice::all();

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

        $validator = Validator::make($request->all(), [ 
			'ANNUAL_FEE_PREFIX' => 'string|required', 
			'ANNUAL_FEE_NUMBER' => 'integer|required', 
			'ANNUAL_FEE_YEAR' => 'integer|required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }
        

        try {
            $data = new AnnualFeeInvoice;
            $data->ANNUAL_FEE_PREFIX = strtoupper($request->ANNUAL_FEE_PREFIX);
            $data->ANNUAL_FEE_NUMBER = $request->ANNUAL_FEE_NUMBER;
            $data->ANNUAL_FEE_YEAR = $request->ANNUAL_FEE_YEAR;
            $data->save();
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully create.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'ANNUAL_FEE_PREFIX' => 'string|nullable', 
			'ANNUAL_FEE_NUMBER' => 'integer|nullable', 
			'ANNUAL_FEE_YEAR' => 'integer|nullable' 
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
        $validator = Validator::make($request->all(), [ 
			'ANNUAL_FEE_PREFIX' => 'string|required', 
			'ANNUAL_FEE_NUMBER' => 'integer|required', 
			'ANNUAL_FEE_YEAR' => 'integer|required' 
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = AnnualFeeInvoice::find($request->ANNUAL_FEE_INVOICE_ID);
            $data->ANNUAL_FEE_PREFIX = strtoupper($request->ANNUAL_FEE_PREFIX);
            $data->ANNUAL_FEE_NUMBER = $request->ANNUAL_FEE_NUMBER;
            $data->ANNUAL_FEE_YEAR = $request->ANNUAL_FEE_YEAR;
            $data->save();
            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
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
            $data = AnnualFeeInvoice::find($request->ANNUAL_FEE_INVOICE_ID);
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
        $validator = Validator::make($request->all(), [ 
			'ANNUAL_FEE_PREFIX' => 'string|nullable', 
			'ANNUAL_FEE_NUMBER' => 'integer|nullable', 
			'ANNUAL_FEE_YEAR' => 'integer|nullable' 
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
                'message' => 'Filtered data successfully retrieved.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ],400);
        }
    }
}

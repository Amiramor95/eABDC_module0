<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\DistributorApprovalLevel;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class DistributorApprovalLevelController extends Controller
{
    public function getDistByIndex (Request $request)
    {
        try {
            
            $data = DistributorApprovalLevel::where('APPR_PROCESSFLOW_ID',$request->APPR_PROCESSFLOW_ID)
            ->where('APPR_INDEX',$request->APPR_INDEX)->get();

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

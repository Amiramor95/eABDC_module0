<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataRetention;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;
use Validator;
use Artisan;
use DB;
use File;

class DataRetentionController extends Controller
{
    //
    public function get(Request $request)
    {
        try {
            $data = DataRetention::first();

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
        //return $request->all();
        $validator = Validator::make($request->all(), [
                'RETENTION_DURATION' => 'required'
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

        try {
                $data =  DataRetention::first();
                $data->RETENTION_DURATION = $request->RETENTION_DURATION;
                $data->save();
                //Save function

                http_response_code(200);
                return response([
                    'message' => 'Data successfully saved.'
                ]);
            } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function archive(Request $request)
    {
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'RETENTION_DURATION' => 'required'
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

        try {
               //Artisan::call('retention:data-retention');
               $mysqlPath = env('MYSQL_DUMP_PATH'); //"D:\ibcs-project\mysql\bin\mysqldump";
               $database_name = [
                   'distributor_management',
                   'consultant_management',
                   'cpd_management',
                   'annualFee_management'
               ];
               $path = public_path('data-retention/'. date("d-m-Y-H-i-s"));
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }
                foreach($database_name as $data_name){
                    $filename = $data_name . ".sql";
                    $command = "$mysqlPath --user=" 
                    . env('DB_USERNAME') 
                    ." --password=" 
                    . env('DB_PASSWORD') 
                    . " --host=" 
                    . env('DB_HOST') 
                    . " " . $data_name . "  > " 
                    . $path . "/" 
                    . $filename."  2>&1";
                    $returnVar = NULL;
                    $output  = NULL;
                    exec($command, $output, $returnVar);
                }
                
                echo 'Comman Operation Successfull';
                return 1;//ok

                http_response_code(200);
                return response([
                    'message' => 'Database successfully archived !!'
                ]);
            } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    
}

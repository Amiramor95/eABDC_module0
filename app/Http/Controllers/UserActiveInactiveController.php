<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Validator;
use DB;

class UserActiveInactiveController extends Controller
{
    //// Active Inactive Controller

    public function get(Request $request){
        //return $request->all();
        try {
            $data = DB::table('USER_ACTIVE_INACTIVE AS AI')->select('*');
                if($request->TYPE){
                    $data->where('AI.TYPE',$request->TYPE);
                    $data =  $data->first();
                }else{
                    $data =  $data->get();
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


    public function create(Request $request){

        //return $request->all();

        // Server validation
        // $validator = Validator::make($request->all(), [ 
		// 	'DURATION' => 'required|integer', 
		// 	'IS_ACTIVE' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Data validation error.',
        //         'errorCode' => 4106,
        //         'error' => $validator->errors()->first()
        //     ],400);
        // }
        
        try {
            if($request->DURATION){
                $data = DB::table('USER_ACTIVE_INACTIVE')->updateOrInsert(
                    ['TYPE' =>  $request->TYPE],
                    [
                    'DURATION' => $request->DURATION,
                    'TYPE' => $request->TYPE,
                    ]
                );
            }else{
                $data = DB::table('USER_ACTIVE_INACTIVE')->updateOrInsert(
                    ['TYPE' =>  $request->TYPE],
                    [
                    'TYPE' => $request->TYPE,
                    'IS_ACTIVE' => ($request->IS_ACTIVE == 'false')  ? 0 : 1,
                    ]
                );
            }
            
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully saved !'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function update(Request $request){

        //return $request->all();

        // Server validation
        $validator = Validator::make($request->all(), [ 
			'DURATION' => 'required|integer', 
			'IS_ACTIVE' => 'required',
            'USER' => 'required', 
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

            $data = DB::table('USER_ACTIVE_INACTIVE')
            ->where('USER_ACTIVE_INACTIVE_ID',$request->USER_ACTIVE_INACTIVE_ID)
            ->update([
                'AI_USER_ID' => $request->USER,
                'DURATION' => $request->DURATION,
                'TYPE' => $request->TYPE,
                'IS_ACTIVE' => ($request->IS_ACTIVE == "true") ? 1 : 0
            ]);
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
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
            $data = DB::table('USER_ACTIVE_INACTIVE')
            ->where('USER_ACTIVE_INACTIVE_ID',$request->USER_ACTIVE_INACTIVE_ID)
            ->delete();
            //$data->delete();

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
}

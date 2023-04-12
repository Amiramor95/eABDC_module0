<?php

namespace App\Http\Controllers;

use App\Models\ManageScreen;
use App\Models\ProcessFlow;
use App\Models\ManageSubmodule;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use DB;
use Validator;
use Illuminate\Validation\Rule;

class ManageScreenController extends Controller
{
    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'MANAGE_MODULE_ID' => 'integer|nullable' ,
            'MANAGE_SUBMODULE_ID' => 'integer|nullable'
        ]);

        try {
            if($request->MANAGE_SUBMODULE_ID){

                        $data = ManageScreen::select('*')
                        ->join('MANAGE_SUBMODULE', 
                        'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 
                        'MANAGE_SCREEN.MANAGE_SUBMODULE_ID')
                        ->join('MANAGE_MODULE', 
                        'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 
                        'MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                        ->where('MANAGE_SCREEN.MANAGE_SUBMODULE_ID',$request->MANAGE_SUBMODULE_ID)
                        ->get();
                        
                        $data->append('selected')->toArray();

                        // $data->append('custom')->toArray();

            }else{
                //get array of submodule by module id
                $submoduleList = ManageSubmodule::where('MANAGE_MODULE_ID',$request->MANAGE_MODULE_ID)
                                 ->get('MANAGE_SUBMODULE_ID');

                $data = ManageScreen::select('*')
                ->join('MANAGE_SUBMODULE', 
                'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 
                'MANAGE_SCREEN.MANAGE_SUBMODULE_ID')
                ->join('MANAGE_MODULE', 
                'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 
                'MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                ->whereIn('MANAGE_SCREEN.MANAGE_SUBMODULE_ID',$submoduleList)
                ->get();
                $data->append('id')->toArray();
                $data->append('selected')->toArray();
            }

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
    public function getScreenId(Request $request)
    {
        try {
			$data = ManageScreen::select('MANAGE_SCREEN.*','MANAGE_SUBMODULE.*','MANAGE_MODULE.*','PROCESS_FLOW.*')
                ->LeftJoin('MANAGE_SUBMODULE','MANAGE_SCREEN.MANAGE_SUBMODULE_ID','MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID')
                ->LeftJoin('MANAGE_MODULE','MANAGE_MODULE.MANAGE_MODULE_ID','MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                ->LeftJoin('PROCESS_FLOW','PROCESS_FLOW.PROCESS_FLOW_ID','MANAGE_SCREEN.SCREEN_PROCESS')
                ->where('MANAGE_SCREEN.MANAGE_SCREEN_ID',$request->MANAGE_SCREEN_ID)
                ->first();  
            
            //find($request->MANAGE_SCREEN_ID); 
        // dd($data);
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
    public function getSubmodule(Request $request)
    {
        try {
            $data = DB::table('MANAGE_SUBMODULE')
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
    public function getProcessFlow(Request $request)
    {
        try {
            $data = DB::table('PROCESS_FLOW')
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
    public function getAll()
    {
        try {
            $data = ManageScreen::select('*')
                    ->join('MANAGE_SUBMODULE', 
                    'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 
                    'MANAGE_SCREEN.MANAGE_SUBMODULE_ID')
                    ->join('MANAGE_MODULE', 
                    'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 
                    'MANAGE_SUBMODULE.MANAGE_MODULE_ID')
                    ->leftJoin('PROCESS_FLOW AS PROCESSFLOW', 'PROCESSFLOW.PROCESS_FLOW_ID', '=', 'MANAGE_SCREEN.SCREEN_PROCESS')
                    ->get();
            $data->append('id')->toArray();        
            $data->append('selected')->toArray();
            $total = $data->count();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data,
                'count' => $total
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

        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'SCREEN_CODE' => 'required|unique:MANAGE_SCREEN,SCREEN_CODE',
            'MANAGE_SUBMODULE_ID' => 'required', 
            'SCREEN_NAME' => 'required', 
            'SCREEN_ROUTE' => 'required', 
            'SCREEN_PROCESS' => 'required',
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }

        try {

            $module = new ManageScreen;
            $module->MANAGE_SUBMODULE_ID = $request->MANAGE_SUBMODULE_ID;
            $module->SCREEN_NAME = strtoupper($request->SCREEN_NAME);
            $module->SCREEN_ROUTE = $request->SCREEN_ROUTE;
            $module->SCREEN_DESCRIPTION = strtoupper($request->SCREEN_DESCRIPTION);
            $module->SCREEN_PROCESS = $request->SCREEN_PROCESS;
            $module->SCREEN_CODE = $request->SCREEN_CODE;
            $module->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
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
			'MANAGE_SUBMODULE_ID' => 'required|integer', 
			'SCREEN_NAME' => 'required|string', 
			'SCREEN_ROUTE' => 'required|string', 
			'SCREEN_PROCESS' => 'required|string', 
			'SCREEN_DESCRIPTION' => 'required|string' 
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
        $messages = [
            'unique' => 'The code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'SCREEN_CODE' => ['required',Rule::unique('MANAGE_SCREEN')->where(function ($query) use ($request) {
                return $query->where('MANAGE_SCREEN_ID', '!=',  $request->MANAGE_SCREEN_ID);
            })],
            'MANAGE_SUBMODULE_ID' => 'required', 
            'SCREEN_NAME' => 'required', 
            'SCREEN_ROUTE' => 'required', 
            'SCREEN_PROCESS' => 'required',
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $data = ManageScreen::find($request->MANAGE_SCREEN_ID);
            $data->MANAGE_SUBMODULE_ID = $request->MANAGE_SUBMODULE_ID;
            $data->SCREEN_NAME = strtoupper($request->SCREEN_NAME);
            $data->SCREEN_ROUTE = $request->SCREEN_ROUTE;
            $data->SCREEN_DESCRIPTION = strtoupper($request->SCREEN_DESCRIPTION);
            $data->SCREEN_PROCESS = $request->SCREEN_PROCESS;
            $data->SCREEN_CODE = $request->SCREEN_CODE;
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
            $data = ManageScreen::find($request->MANAGE_SCREEN_ID);
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
			'MANAGE_SUBMODULE_ID' => 'required|integer', 
			'SCREEN_NAME' => 'required|string', 
			'SCREEN_ROUTE' => 'required|string', 
			'SCREEN_PROCESS' => 'required|string', 
			'SCREEN_DESCRIPTION' => 'required|string' 
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

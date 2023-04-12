<?php

namespace App\Http\Controllers;

use App\Models\ColourTemplateSetting;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ColourTemplateSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ColourTemplateSetting::find($request->COLOUR_SETTING_ID);

            $result = DB::table('USER_COLOUR')->updateOrInsert(
                ['USER_ID' =>  $request->USER_ID,'USER_TYPE' => $request->USER_TYPE],
                [
                    'USER_ID' => $request->USER_ID,
                    'USER_TYPE' => $request->USER_TYPE,
                    'COLOUR_ID' => $request->COLOUR_SETTING_ID 
                ]
            );

            http_response_code(200);
            return response([
                'message' => 'Theme setup successful !!',
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
    public function getAllActiveColor(Request $request)
    {
        try {
            $data = ColourTemplateSetting::where('COLORSTATUS','=','ACTIVE')->orderBy('SET_DEFAULT','desc')->get();

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
    public function getActiveColor(Request $request)
    {
        
        try {
            $colour = DB::table('USER_COLOUR')
            ->where('USER_ID',$request->USER_ID)
            ->where('USER_TYPE',$request->USER_TYPE)->first();
            if($colour){
                $colour_id = $colour->COLOUR_ID;
                $data = ColourTemplateSetting::where('COLOUR_SETTING_ID','=',$colour_id)->first();
            }else{
                $data = ColourTemplateSetting::where('SET_DEFAULT','=',1)->first();
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

    public function getAll()
    {
        try {
            $data = ColourTemplateSetting::all();
            $resp = [];
            foreach($data as $key => $d){
                $resp[$key]['THEME_ACTIVE_COLOR'] = "<span style='display: flex;'>" .$d->THEME_ACTIVE_COLOR . "<span style='background-color:". $d->THEME_ACTIVE_COLOR ."; width: 20px; height: 20px; display: flex;margin-left: 10px;'></span></span>";
                $resp[$key]['THEME_PASSIVE_COLOR'] = "<span style='display: flex;'>" .$d->THEME_PASSIVE_COLOR . "<span style='background-color:". $d->THEME_PASSIVE_COLOR ."; width: 20px; height: 20px; display: flex;margin-left: 10px;'></span></span>";
                $resp[$key]['THEME_TEXT_COLOR'] = "<span style='display: flex;'>" .$d->THEME_TEXT_COLOR . "<span style='background-color:". $d->THEME_TEXT_COLOR ."; width: 20px; height: 20px; display: flex;margin-left: 10px;'></span></span>";
                $resp[$key]['COLOUR_SETTING_ID'] = $d->COLOUR_SETTING_ID;
                $resp[$key]['THEME_NAME'] = $d->THEME_NAME;
                $resp[$key]['SET_DEFAULT'] = $d->SET_DEFAULT;
                $resp[$key]['CREATE_BY'] = $d->CREATE_BY;
                $resp[$key]['CREATE_TIMESTAMP'] = $d->CREATE_TIMESTAMP;
            }
            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $resp
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
        $validator = Validator::make($request->all(), [ //fresh
            'THEME_NAME' => 'required|string',
            'THEME_ACTIVE_COLOR' => 'required|string',
            'THEME_PASSIVE_COLOR' => 'required|string',
            'THEME_TEXT_COLOR' => 'required|string',
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
            $create_by=$request->header('Uid');
            $themename = ColourTemplateSetting::where('THEME_NAME', strtoupper($request['THEME_NAME']))->first();
            if(!$themename)
            {
            //create function
            $data = new ColourTemplateSetting;
            $data->THEME_NAME = strtoupper($request->THEME_NAME);
            $data->THEME_ACTIVE_COLOR = $request->THEME_ACTIVE_COLOR;
            $data->THEME_PASSIVE_COLOR = $request->THEME_PASSIVE_COLOR;
            $data->THEME_TEXT_COLOR = $request->THEME_TEXT_COLOR;
            $data->COLORSTATUS = $request->COLORSTATUS;
            $data->CREATE_BY = $create_by;
            $data->save();
            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
            ]);
            }
            else{
                http_response_code(400);
                return response([
                    'message' => 'Theme Already Exists!!',
                    'errorCode' => 4100
                ],400);

            }

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
        $validator = Validator::make($request->all(), [ //fresh
            'THEME_NAME' => 'required|string',
            'THEME_ACTIVE_COLOR' => 'required|string',
            'THEME_PASSIVE_COLOR' => 'required|string',
            'THEME_TEXT_COLOR' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }
        try {
            $data = ColourTemplateSetting::find($request->COLOUR_SETTING_ID);
            if($data->THEME_NAME === strtoupper($request->THEME_NAME))
            {
            $data->THEME_NAME = strtoupper($request->THEME_NAME);
            $data->THEME_ACTIVE_COLOR = $request->THEME_ACTIVE_COLOR;
            $data->THEME_PASSIVE_COLOR = $request->THEME_PASSIVE_COLOR;
            $data->THEME_TEXT_COLOR = $request->THEME_TEXT_COLOR;
            $data->COLORSTATUS = $request->COLORSTATUS;
            $data->save();
            http_response_code(200);
            return response([
                'message' => 'Data Successfully Updated'
            ]);
            }
            if($data->THEME_NAME !== strtoupper($request->THEME_NAME))
            {
            $themename = ColourTemplateSetting::where('THEME_NAME', strtoupper($request['THEME_NAME']))->first();
                if(!$themename)
                {
                    //$data = new ColourTemplateSetting;
                    $data->THEME_NAME = strtoupper($request->THEME_NAME);
                    $data->THEME_ACTIVE_COLOR = $request->THEME_ACTIVE_COLOR;
                    $data->THEME_PASSIVE_COLOR = $request->THEME_PASSIVE_COLOR;
                    $data->THEME_TEXT_COLOR = $request->THEME_TEXT_COLOR;
                    $data->COLORSTATUS = $request->COLORSTATUS;
                    $data->save();
                    http_response_code(200);
                    return response([
                        'message' => 'Data successfully updated.'
                    ]);
                    }
                    else{
                        http_response_code(400);
                        return response([
                            'message' => 'Theme Already Exists!!',
                            'errorCode' => 4100
                        ],400);

                    }
            }

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
            $data = ColourTemplateSetting::find($request->COLOUR_SETTING_ID);
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
    public function setDefaultColour(Request $request)
    {
        try {

            Log::info( "color ===>" . $request->COLOUR_SETTING_ID);
            $data = ColourTemplateSetting::find($request->COLOUR_SETTING_ID);
            $update=DB::table('admin_management.COLOUR_TEMPLATE_SETTING as ACT')->where('ACT.SET_DEFAULT', 1)->update(['ACT.SET_DEFAULT' => 0]);
              $data->where('COLOUR_SETTING_ID',$request->COLOUR_SETTING_ID)->update([
                'SET_DEFAULT' => 1,
                ]);
            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.'
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

<?php

namespace App\Http\Controllers;

use App\Models\SettingCalendar;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingCalendarController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = SettingCalendar::find($request->SETTING_CALENDAR_ID);

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
            $data = SettingCalendar::orderby('SETTING_CALENDAR_ID', 'desc')->get();//all();
            // foreach($data as $element){
            //     $element->CALENDAR_DATE_START = date('d-M-Y', strtotime($element->CALENDAR_DATE_START));
            //     $element->CALENDAR_DATE_END = date('d-M-Y', strtotime($element->CALENDAR_DATE_END));
            // }
            $resp = [];
            foreach($data as $key => $d){
                  
                // $new_date = date('Y-m-d h:i:s', strtotime($d->CALENDAR_DATE_START));
                //$new_date1 = date('Y-m-d h:i:s', strtotime($d->CALENDAR_DATE_END));
                $resp[$key]['SETTING_CALENDAR_ID'] = $d->SETTING_CALENDAR_ID;
                $resp[$key]['CALENDAR_NAME'] = $d->CALENDAR_NAME;
                $resp[$key]['CALENDAR_DATE_START'] = date('d/m/Y', strtotime($d->CALENDAR_DATE_START));
                $resp[$key]['CALENDAR_DATE_END'] = date('d/m/Y', strtotime($d->CALENDAR_DATE_END));
                $resp[$key]['CALENDAR_DATE_START_EVENT'] = $d->CALENDAR_DATE_START;
                $resp[$key]['CALENDAR_DATE_END_EVENT'] = $d->CALENDAR_DATE_END;
               // $resp[$key]['CALENDAR_DATE_START_EVENT1'] = $new_date;
                //$resp[$key]['CALENDAR_DATE_END_EVENT2'] = $new_date1;
                $resp[$key]['CALENDAR_DESCRIPTION'] = $d->CALENDAR_DESCRIPTION;
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
            $validator = Validator::make($request->all(), [
            'CALENDAR_NAME' => 'required',
            'CALENDAR_DATE_START' => 'required',
            'CALENDAR_DATE_END' => 'required',
            'CALENDAR_DESCRIPTION' => 'required',
            ]);
            if ($validator->fails()) {
                http_response_code(400);
                return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
                ],400);
            }

        try {
            $data = new SettingCalendar;
            $data->CALENDAR_NAME = $request->CALENDAR_NAME;
            $data->CALENDAR_DATE_START = $request->CALENDAR_DATE_START;
            $data->CALENDAR_DATE_END = $request->CALENDAR_DATE_END;
            $data->CALENDAR_DESCRIPTION = $request->CALENDAR_DESCRIPTION;
            $data->CREATE_BY = $request->CREATE_BY;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully added.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be added.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function create_multi_cal(Request $request)
    {
            // $validator = Validator::make($request->all(), [
            // 'CALENDAR_NAME' => 'required',
            // 'CALENDAR_DATE_START' => 'required',
            // 'CALENDAR_DATE_END' => 'required',
            // 'CALENDAR_DESCRIPTION' => 'required',
            // ]);
            // if ($validator->fails()) {
            //     http_response_code(400);
            //     return response([
            //     'message' => 'Data validation error.',
            //     'errorCode' => 4106
            //     ],400);
            // }

            //
          //  $auser=Auth::user();
            // Log::info( "authout ===>" . $request->header('Uid'));

        try {
            $create_by=$request->header('Uid');
            $contents  = json_decode($request->getContent(), true);
            foreach($contents as $content){
                //var_dump( $content );
                $data = new SettingCalendar;
                $data->CALENDAR_NAME = $content["CALENDAR_NAME"];
                $data->CALENDAR_DATE_START = date('Y-m-d', strtotime($content["CALENDAR_DATE_START"]));
                $data->CALENDAR_DATE_END = date('Y-m-d', strtotime($content["CALENDAR_DATE_END"]));
                $data->CALENDAR_DESCRIPTION = $content["CALENDAR_DESCRIPTION"];
                $data->CREATE_BY = $create_by;
                $data->save();
            }
            http_response_code(200);
            return response([
                'message' => 'Data successfully added.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be added.',
                'errorCode' => 4100
            ],400);
        }

    }
    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
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
            'SETTING_CALENDAR_ID' => 'required|integer', //1
            'CALENDAR_NAME' => 'required|string', //Cuti raya cina
            'CALENDAR_DATE_START' => 'required|string', //2021-02-13
            'CALENDAR_DATE_END' => 'required|string', //2021-02-14
            'CALENDAR_DESCRIPTION' => 'required|string', //Cuti hari raya cina
            'CREATE_BY' => 'required|integer' //1
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = SettingCalendar::find($request->SETTING_CALENDAR_ID);
            $data->CALENDAR_NAME = $request->CALENDAR_NAME;
            $data->CALENDAR_DATE_START = $request->CALENDAR_DATE_START;
            $data->CALENDAR_DATE_END = $request->CALENDAR_DATE_END;
            $data->CALENDAR_DESCRIPTION = $request->CALENDAR_DESCRIPTION;
            $data->CREATE_BY = $request->CREATE_BY;
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
            $data = SettingCalendar::find($request->SETTING_CALENDAR_ID);
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
                $query = SettingCalendar::select('*');
                if ($request->CALENDAR_NAME != null) {
                    $query->where('CALENDAR_NAME', 'like', '%' . $request->CALENDAR_NAME . '%');
                }
                if ($request->CALENDAR_DATE_START != null) {
                    $query->where('CALENDAR_DATE_START', $request->CALENDAR_DATE_START);
                }
                if ($request->CALENDAR_DATE_END != null) {
                    $query->where('CALENDAR_DATE_END', $request->CALENDAR_DATE_END);
                }
                if ($request->CALENDAR_DESCRIPTION != null) {
                    $query->where('CALENDAR_DESCRIPTION', 'like', '%' . $request->CALENDAR_DESCRIPTION . '%');
                }

                $data = $query->get();

                foreach($data as $item){
                    $item->CALENDAR_DATE_START = date('d-m-Y', strtotime($item->CALENDAR_DATE_START));
                    $item->CALENDAR_DATE_END = date('d-m-Y', strtotime($item->CALENDAR_DATE_END));
                    $item->CALENDAR_NAME = $item->CALENDAR_NAME == null ? "-" : $item->CALENDAR_NAME;
                }

            http_response_code(200);
            return response([
                'message' => 'Filtered data successfully retrieved.',
                'data' => $data
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

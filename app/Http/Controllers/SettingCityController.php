<?php

namespace App\Http\Controllers;

use App\Models\SettingCity;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class SettingCityController extends Controller
{
    public function get(Request $request)
    {
        try {
            // DB::enableQueryLog();
			$data = DB::table ('admin_management.SETTING_CITY AS A')
			->select('A.SET_CITY_NAME AS SET_CITY_NAME', 'A.SETTING_CITY_ID AS SETTING_CITY_ID', 'B.SET_PARAM')
			->join('SETTING_GENERAL AS B', 'B.SETTING_GENERAL_ID', '=', 'A.SETTING_GENERAL_ID')
            ->where('A.SETTING_GENERAL_ID', $request->SETTING_GENERAL_ID)
            ->get();
            // dd(DB::getQueryLog());

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
            $data = SettingCity::all();

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
			'SET_CITY_NAME' => 'required|string',
			'SETTING_GENERAL_ID' => 'required|integer',
			'CITY_CREATE_BY' => 'required|string',
			'CITY_CREATE_TIMESTAMP' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = new SettingCity;
            $data->SETTING_GENERAL_ID = $request->SETTING_GENERAL_ID;
            $data->SET_CITY_NAME = $request->SET_CITY_NAME;
            $data->save();

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

    public function manage(Request $request)
    {
$validator = Validator::make($request->all(), [
			'SET_CITY_NAME' => 'required|string',
			'SETTING_GENERAL_ID' => 'required|integer',
			'CITY_CREATE_BY' => 'required|string',
			'CITY_CREATE_TIMESTAMP' => 'required|string'
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

    public function update(Request $request, $id)
    {
$validator = Validator::make($request->all(), [
			'SET_CITY_NAME' => 'required|string',
			'SETTING_GENERAL_ID' => 'required|integer',
			'CITY_CREATE_BY' => 'required|string',
			'CITY_CREATE_TIMESTAMP' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $data = SettingCity::where('id',$id)->first();
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
            ],400);
        }
    }

    public function delete($id)
    {
        try {
            $data = SettingCity::find($id);
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
			'SET_CITY_NAME' => 'required|string',
			'SETTING_GENERAL_ID' => 'required|integer',
			'CITY_CREATE_BY' => 'required|string',
			'CITY_CREATE_TIMESTAMP' => 'required|string'
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

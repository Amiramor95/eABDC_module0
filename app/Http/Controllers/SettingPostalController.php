<?php

namespace App\Http\Controllers;

use App\Models\SettingPostal;
use App\Models\SettingCity;
use App\Models\SettingGeneral;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Log;

class SettingPostalController extends Controller
{
    // public function get(Request $request)
    // {
    //     try {

    //         $data = DB::table('SETTING_POSTAL AS SETTING_POSTAL')
    //         ->select('SETTING_POSTAL.SETTING_POSTCODE_ID', 'SETTING_POSTAL.POSTCODE_NO AS POSTCODE_NO', 'SETTING_CITY.SET_CITY_NAME AS CITY_NAME', 'SETTING_STATE.SETTING_GENERAL_ID AS STATE_ID', 'SETTING_STATE.SET_PARAM AS SET_STATE', 'SETTING_COUNTRY.SETTING_GENERAL_ID','SETTING_COUNTRY.SET_PARAM AS COUNTRY_NAME')
    //         ->leftJoin('SETTING_CITY AS SETTING_CITY', 'SETTING_CITY.SETTING_CITY_ID', '=', 'SETTING_POSTAL.SETTING_POSTCODE_ID')
    //         ->leftJoin ('SETTING_GENERAL AS SETTING_STATE', 'SETTING_STATE.SETTING_GENERAL_ID', '=', 'SETTING_CITY.SETTING_GENERAL_ID')
    //         ->leftJoin('SETTING_GENERAL AS SETTING_COUNTRY', 'SETTING_COUNTRY.SETTING_GENERAL_ID', '=', 'SETTING_STATE.SET_VALUE')
    //         ->where('SETTING_POSTAL.SETTING_POSTCODE_ID', $request->SETTING_POSTCODE_ID)
    //         ->get();



    //         http_response_code(200);
    //         return response([
    //             'message' => 'Data successfully retrieved.',
    //             'data' => $data

    //         ]);
    //     } catch (RequestException $r) {

    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to retrieve data.',
    //             'errorCode' => 4103
    //         ],400);
    //     }
    // }
    public function get(Request $request)
    {
        try {

            $data = DB::table('admin_management.SETTING_POSTAL AS POSKOD')
                ->select(
                    'POSKOD.SETTING_POSTCODE_ID',
                    'POSKOD.POSTCODE_NO AS POSTCODE',
                    'CITY.SETTING_CITY_ID AS CITY_ID',
                    'CITY.SET_CITY_NAME AS CITY',
                    'STATE.SETTING_GENERAL_ID AS STATE_ID',
                    'STATE.SET_PARAM AS SET_STATE',
                    'COUNTRY.SETTING_GENERAL_ID AS COUNTRY_ID',
                    'COUNTRY.SET_PARAM AS COUNTRY'
                )
                ->leftJoin('SETTING_CITY AS CITY', 'POSKOD.SETTING_CITY_ID', '=', 'CITY.SETTING_CITY_ID')
                ->leftJoin('SETTING_GENERAL AS STATE', 'STATE.SETTING_GENERAL_ID', '=', 'CITY.SETTING_GENERAL_ID')
                ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
                ->where('POSKOD.SETTING_POSTCODE_ID', $request->SETTING_POSTCODE_ID)
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
    public function getPostalByID(Request $request)
    {
        try {

            $data = DB::table('admin_management.SETTING_POSTAL AS POSKOD')
                ->select('POSKOD.SETTING_POSTCODE_ID', 'POSKOD.SETTING_POSTCODE_ID AS POSTCODE_ID', 'POSKOD.POSTCODE_NO AS POSTCODE', 'CITY.SETTING_CITY_ID AS CITY_ID', 'CITY.SET_CITY_NAME AS CITY', 'STATE.SETTING_GENERAL_ID AS STATE_ID', 'STATE.SET_PARAM AS STATE', 'COUNTRY.SETTING_GENERAL_ID AS COUNTRY_ID', 'COUNTRY.SET_PARAM AS COUNTRY')
                ->leftJoin('admin_management.SETTING_CITY AS CITY', 'POSKOD.SETTING_CITY_ID', '=', 'CITY.SETTING_CITY_ID')
                ->leftJoin('admin_management.SETTING_GENERAL AS STATE', 'STATE.SETTING_GENERAL_ID', '=', 'CITY.SETTING_GENERAL_ID')
                ->leftJoin('admin_management.SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
                ->where('POSKOD.SETTING_CITY_ID', '=', $request->SETTING_CITY_ID)
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


    public function getAll()
    {
        try {
            $data = DB::table('admin_management.SETTING_POSTAL AS POSKOD')
                ->select('POSKOD.SETTING_POSTCODE_ID', 'POSKOD.POSTCODE_NO AS POSTCODE', 'CITY.SETTING_CITY_ID AS CITY_ID', 'CITY.SET_CITY_NAME AS CITY', 'STATE.SETTING_GENERAL_ID AS STATE_ID', 'STATE.SET_PARAM AS STATE', 'COUNTRY.SETTING_GENERAL_ID AS COUNTRY_ID', 'COUNTRY.SET_PARAM AS COUNTRY')
                ->leftJoin('SETTING_CITY AS CITY', 'POSKOD.SETTING_CITY_ID', '=', 'CITY.SETTING_CITY_ID')
                ->leftJoin('SETTING_GENERAL AS STATE', 'STATE.SETTING_GENERAL_ID', '=', 'CITY.SETTING_GENERAL_ID')
                ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
                ->where('STATE.SET_TYPE', '=', 'STATE')
                ->get();

            foreach ($data as $item) {
                if ($item->POSTCODE != null) {
                } else {
                    $item->POSTCODE = $item->POSTCODE ?? '-';
                }

                if ($item->CITY) {
                } else {
                    $item->CITY = $item->CITY ?? '-';
                }

                if ($item->STATE) {
                } else {
                    $item->STATE = $item->STATE ?? '-';
                }
                if ($item->COUNTRY) {
                } else {
                    $item->COUNTRY = $item->COUNTRY ?? '-';
                }
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
            ], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            $create_by=$request->header('Uid');
            $dataSettingCity = new SettingCity;
            // $dataSettingCity->SETTING_CITY_ID = $request->SETTING_CITY_ID;
            $dataSettingCity->SETTING_GENERAL_ID = $request->SETTING_GENERAL_ID;
            $dataSettingCity->SET_CITY_NAME = strtoupper($request->SET_CITY_NAME);
            $dataSettingCity->CITY_CREATE_BY = $create_by;
            $dataSettingCity->save();

            $dataSettingPostal = new SettingPostal;
            $dataSettingPostal->POSTCODE_NO = $request->POSTCODE_NO;
            $dataSettingPostal->SETTING_CITY_ID = $dataSettingCity->SETTING_CITY_ID;
            $dataSettingPostal->POSTCODE_CREATE_BY = $create_by;
            $dataSettingPostal->save();
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
            ], 400);
        }
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'POSTCODE_NO' => 'required|string',
            'SETTING_CITY_ID' => 'required|integer',
            'POSTCODE_CREATE_BY' => 'required|string',
            'POSTCODE_CREATE_TIMESTAMP' => 'required|string'
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
            'POSTCODE_NO' => 'nullable|string'

        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            Log::info( "State Data ===>" . $request);
            $dataSettingCity = SettingCity::find($request->SETTING_CITY_ID);
            $dataSettingCity->SETTING_GENERAL_ID = $request->SETTING_GENERAL_ID;
            $dataSettingCity->SET_CITY_NAME = $request->SET_CITY_NAME;
            $dataSettingCity->save();

            $dataSettingPostal = SettingPostal::find($request->SETTING_POSTCODE_ID);
            $dataSettingPostal->SETTING_CITY_ID = $dataSettingCity->SETTING_CITY_ID;
            $dataSettingPostal->POSTCODE_NO = $request->POSTCODE_NO;
            // $data->SET_CITY_NAME = $request->SET_CITY_NAME;
            $dataSettingPostal->save();


            http_response_code(200);
            return response([
                'message' => 'Data Updated'
                // 'data' => $data,
                // 'dataCity' => $dataSettingCity,
                // 'dataPostcode' => $dataSettingPostal

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
            $data = SettingPostal::find($request->SETTING_POSTCODE_ID);
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
            ], 400);
        }
    }

    public function filter(Request $request)
    {

        try {

            $data = DB::table('admin_management.SETTING_POSTAL AS POSKOD')
            ->select('POSKOD.SETTING_POSTCODE_ID', 'POSKOD.POSTCODE_NO AS POSTCODE', 'CITY.SETTING_CITY_ID AS CITY_ID', 'CITY.SET_CITY_NAME AS CITY', 'STATE.SETTING_GENERAL_ID AS STATE_ID', 'STATE.SET_PARAM AS STATE', 'COUNTRY.SETTING_GENERAL_ID AS COUNTRY_ID', 'COUNTRY.SET_PARAM AS COUNTRY')
            ->leftJoin('SETTING_CITY AS CITY', 'POSKOD.SETTING_CITY_ID', '=', 'CITY.SETTING_CITY_ID')
            ->leftJoin('SETTING_GENERAL AS STATE', 'STATE.SETTING_GENERAL_ID', '=', 'CITY.SETTING_GENERAL_ID')
            ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
            ->where('CITY.SETTING_GENERAL_ID', $request->SETTING_GENERAL_ID)
            ->get();
            //dd($data);


           /* $query = DB::table('SETTING_POSTAL AS SETTING_POSTAL')
                ->select('SETTING_POSTAL.SETTING_POSTCODE_ID', 'CITY.SET_CITY_NAME', 'CITY.SETTING_GENERAL_ID', 'STATE.SETTING_GENERAL_ID AS STATE_ID', 'STATE.SET_PARAM AS STATE_NAME')
                ->leftJoin('SETTING_CITY AS CITY', 'SETTING_POSTAL.SETTING_CITY_ID', '=', 'CITY.SETTING_CITY_ID')
                ->leftJoin('SETTING_GENERAL AS STATE', 'STATE.SETTING_GENERAL_ID', '=', 'CITY.SETTING_GENERAL_ID');
            if ($request->SETTING_GENERAL_ID != null) {
                $query->where('CITY.SETTING_GENERAL_ID', $request->SETTING_GENERAL_ID);
            }
            $data = $query->get();*/



            //manage function


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
            ], 400);
        }
    }
    public function bulkUploadPostalCode(Request $request)
    {
        $create_by = $request->header('Uid');
        $set_type='STATE';
        $set_type_country='COUNTRY';
        $SETTING_GENERAL_ID_CON='';
        $SETTING_GENERAL_ID_STATE='';
        try {
            $contents  = json_decode($request->getContent(), true);
            foreach($contents as $element){
                $stateExits = SettingGeneral::where('SET_TYPE', 'STATE')->where('SET_PARAM', strtoupper($element["STATE"]))->first();

                $countryExits = SettingGeneral::where('SET_TYPE', 'COUNTRY')->where('SET_PARAM', strtoupper($element["COUNTRY"]))->where('SET_CODE', strtoupper($element["COUNTRY_CODE"]))->first();

                $bulkuploadState = new SettingGeneral;
                $bulkuploadPostcode = new SettingPostal;
                $bulkuploadCity = new SettingCity;
                if(!$countryExits){
                    // Country Upload
                $bulkuploadCountry = new SettingGeneral;
                $bulkuploadCountry->SET_PARAM = strtoupper($element["COUNTRY"]);
                $bulkuploadCountry->SET_TYPE = $set_type_country;
                $bulkuploadCountry->SET_CODE = strtoupper($element["COUNTRY_CODE"]);
                $bulkuploadCountry->SET_CREATE_BY = $create_by;
                $bulkuploadCountry->save();
                $SETTING_GENERAL_ID_CON= $bulkuploadCountry->SETTING_GENERAL_ID;
                }
                else{
                    $SETTING_GENERAL_ID_CON=$countryExits->SETTING_GENERAL_ID;
                }
                if(!$stateExits){
                     // State Upload
                $bulkuploadState->SET_PARAM = $element["STATE"];
                $bulkuploadState->SET_TYPE = $set_type;
                $bulkuploadState->SET_VALUE = $SETTING_GENERAL_ID_CON;
                $bulkuploadState->SET_CREATE_BY = $create_by;
                $bulkuploadState->save();
                $SETTING_GENERAL_ID_STATE=$bulkuploadState->SETTING_GENERAL_ID;
                }
                else{
                    $SETTING_GENERAL_ID_STATE=$stateExits->SETTING_GENERAL_ID;
                }

                $bulkuploadCity->SET_CITY_NAME = $element["CITY"];
                $bulkuploadCity->SETTING_GENERAL_ID = intval($SETTING_GENERAL_ID_STATE);
                $bulkuploadCity->CITY_CREATE_BY = $create_by;
                $bulkuploadCity->save();

                $bulkuploadPostcode->POSTCODE_NO = $element["POSTCODE"];
                $bulkuploadPostcode->SETTING_CITY_ID = $bulkuploadCity->SETTING_CITY_ID;
                $bulkuploadPostcode->POSTCODE_CREATE_BY = $create_by;
                $bulkuploadPostcode->save();
             }
            http_response_code(200);
            return response([
            'message' => 'Data successfully Added.',
            'data' => $bulkuploadPostcode
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

<?php

namespace App\Http\Controllers;

use App\Models\SettingGeneral;
use DB;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Log;

class SettingGeneralController extends Controller
{
    public function get(Request $request)
    {
        try {
			$data = SettingGeneral::find($request->SETTING_GENERAL_ID);

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

    public function getAllCurrency()
    {
        try {
            $data = DB::table('SETTING_GENERAL AS SG')
            ->select('*')
            ->where('SG.SET_TYPE', '=', 'CURRENCY')
            ->get();
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

    public function getCurrency(Request $request)
    {
        try {
			$data = SettingGeneral::where('SET_TYPE',$request->SET_TYPE)
            ->where('SET_PARAM',$request->SET_PARAM)
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
            ],400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            //$data = SettingGeneral::where('SET_TYPE',$request->SET_TYPE)->get();
            $query = SettingGeneral::select('*');
                if ($request->SETTING_GENERAL_ID != null) {
                    $query->where('SETTING_GENERAL_ID', $request->SETTING_GENERAL_ID);
                }
                if ($request->SET_TYPE != null) {
                    $query->where('SET_TYPE', $request->SET_TYPE);
                }

            $data = $request->SETTING_GENERAL_ID == null ? $query->get() : $query->first();

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

    public function getDefaultCountry()
    {
        try {
           $data = SettingGeneral::where('SET_CODE','MY')->first();

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

    public function getAllCountry(Request $request)
    {
        try {
            $data = SettingGeneral::where('SET_TYPE','COUNTRY')->get();

            foreach($data as $item){
            if ($item->SET_PARAM !=null){
               $item->SET_PARAM=strtoupper($item->SET_PARAM);
            }else
            {$item->SET_PARAM = strtoupper($item->SET_PARAM) ?? '-' ; }
            if ($item->SET_CODE){

            }else {$item->SET_CODE = $item->SET_CODE ?? '-' ;}

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

    // public function getCountryList(Request $request)
    // {
    //     try {
    //         // s

    //         $successCountry = array();
    //         $list = $request->COUNTRY_LIST;
    //         foreach(json_decode($list) as $element){
    //             $successCountry[] = $element;
    //         }

    //     }



    //         http_response_code(200);
    //         return response([
    //             'message' => 'All data successfully retrieved.',
    //             'data' => ([
    //                 'successCountry' => $successCountry,
    //             ]),
    //         ]);
    //     } catch (RequestException $r) {

    //         http_response_code(400);
    //         return response([
    //             'message' => 'Failed to retrieve all data.',
    //             'errorCode' => 4103
    //         ],400);
    //     }
    // }

    public function getCountry(Request $request)
    {
        try {
			$data = SettingGeneral::find($request->SETTING_GENERAL_ID);

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




    public function getAllState()
    {
        try {
             $data = DB::table('SETTING_GENERAL AS STATE')
            ->select('STATE.SETTING_GENERAL_ID','STATE.SET_PARAM AS SET_STATE', 'COUNTRY.SET_PARAM AS SET_COUNTRY')
            ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
            ->where('STATE.SET_TYPE', '=', 'STATE')
            ->get();

            foreach($data as $item){
                if ($item->SET_STATE!=null){
                    $item->SET_STATE=strtoupper($item->SET_STATE);
                }else
                {$item->SET_STATE = strtoupper($item->SET_STATE) ?? '-' ; }
                if ($item->SET_COUNTRY){
                    $item->SET_COUNTRY=strtoupper($item->SET_COUNTRY);
                }else {$item->SET_COUNTRY = strtoupper($item->SET_COUNTRY) ?? '-' ;}

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

    public function getState(Request $request)
    {
        try {

			// $data = SettingGeneral::find($request->SETTING_GENERAL_ID);

            $data = DB::table('SETTING_GENERAL AS SETTING_GENERAL')
            ->select('SETTING_GENERAL.SETTING_GENERAL_ID', 'SETTING_GENERAL.SET_PARAM AS STATE_PARAM', 'SETTING_GENERAL.SET_VALUE AS STATE_VALUE', 'SETTING_COUNTRY.SETTING_GENERAL_ID AS COUNTRY_ID', 'SETTING_COUNTRY.SET_PARAM')
            ->leftJoin('SETTING_GENERAL AS SETTING_COUNTRY', 'SETTING_COUNTRY.SETTING_GENERAL_ID', '=','SETTING_GENERAL.SET_VALUE')
            ->where('SETTING_GENERAL.SETTING_GENERAL_ID',$request->SETTING_GENERAL_ID)
            ->first();




            //tambah query db

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

    public function getAllCitizenship(Request $request)
    {
        try {

            $data = DB::table('SETTING_GENERAL AS SETTING_GENERAL')
            ->select('SETTING_GENERAL.SETTING_GENERAL_ID', 'SETTING_GENERAL.SET_PARAM')
            ->where('SETTING_GENERAL.SET_TYPE','CITIZENSHIP')
            ->get();

            //tambah query db

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


    public function getOtherUserCategory(Request $request)
    {
        try {
            $data = SettingGeneral::where('SET_TYPE',$request->SET_TYPE)->where('SET_CODE',$request->SET_CODE)->get();
            foreach($data as $item){
                $item->setSelected(false);
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
$validator = Validator::make($request->all(), [
			'SET_TYPE' => 'string|nullable',
			'SET_CODE' => 'string|nullable',
			'SET_PARAM' => 'string|nullable',
			'SET_VALUE' => 'integer|nullable',
			'SET_INDEX' => 'integer|nullable',
			'SET_DESCRIPTION' => 'string|nullable',
			'SET_CREATE_BY' => 'integer|nullable',
			'SET_CREATE_TIMESTAMP' => 'integer|nullable'
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
             $data = new SettingGeneral;
             $data->SET_PARAM = strtoupper($request->SET_PARAM);
             $data->SET_TYPE = strtoupper($request->SET_TYPE);
             $data->SET_CODE = strtoupper($request->SET_CODE);
             $data->SET_VALUE = $request->SET_VALUE;
             $data->SET_CREATE_BY = $create_by;
             $data->save();

            //  foreach(json_decode($request->COUNTRY_LIST) as $element){
            //     $bulkupload = new SettingGeneral;
            //     $bulkupload->SET_PARAM = $element->SET_PARAM;
            //     $bulkupload->SET_TYPE = $element->SET_TYPE;
            //     $bulkupload->SET_VALUE = $element->SET_VALUE;
            //     $bulkupload->save();
            //    }

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.',
                'data' => $data
                // 'bulkUpload' => $bulkupload
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function bulkUpload(Request $request)
    {

       /* try {
            //bulk upload create function
            foreach(json_decode($request->COUNTRY_LIST) as $element){
             $bulkupload = new SettingGeneral;
             $bulkupload->SET_PARAM = $element->SET_PARAM;
             $bulkupload->SET_TYPE = $element->SET_TYPE;
             $bulkupload->SET_VALUE = $element->SET_VALUE;
             $bulkupload->save();
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.',
                'data' => $bulkupload
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }*/

    }

    public function bulkUploadCountry(Request $request)
    {
        $create_by=$request->header('Uid');
        //Log::info( "SETTYPE ===>" . $request);
         $set_type='COUNTRY';
         try {
            $contents  = json_decode($request->getContent(), true);
             //Log::info( "SETTYPE ===>" . $contents);
             //bulk upload create function
           foreach($contents as $element){
              $bulkupload = new SettingGeneral;
              $bulkupload->SET_PARAM = strtoupper($element["COUNTRY_CODE"]);
              $bulkupload->SET_TYPE = $set_type;
              $bulkupload->SET_CODE = strtoupper($element["COUNTRY"]);
              $bulkupload->SET_CREATE_BY = $create_by;
              $bulkupload->save();
             }
             http_response_code(200);
             return response([
                 'message' => 'Data successfully Added.',
                 'data' => $bulkupload
             ]);

         } catch (RequestException $r) {
             http_response_code(400);
             return response([
                 'message' => 'Data failed to be updated.',
                 'errorCode' => 4100
             ],400);
         }
    }
    public function bulkUploadState(Request $request)
    {
        $create_by=$request->header('Uid');
       // Log::info( "SETTYPE ===>" . $request);
         $set_type='STATE';
         $set_type_country='COUNTRY';
         $SETTING_GENERAL_ID_CON='';
         try {
            $contents  = json_decode($request->getContent(), true);
             //Log::info( "SETTYPE ===>" . $contents);
             //bulk upload create function
            foreach($contents as $element){
            $countryExits = SettingGeneral::where('SET_TYPE', 'COUNTRY')->where('SET_PARAM', strtoupper($element["COUNTRY"]))->where('SET_CODE', strtoupper($element["COUNTRY_CODE"]))->first();
                if(!$countryExits){
                    // Country Upload
                    $bulkuploadCountry = new SettingGeneral;
                    $bulkuploadCountry->SET_PARAM = strtoupper($element["COUNTRY"]);
                    $bulkuploadCountry->SET_TYPE = $set_type_country;
                    $bulkuploadCountry->SET_CODE = strtoupper($element["COUNTRY_CODE"]);
                    $bulkuploadCountry->SET_CREATE_BY = $create_by;
                    $bulkuploadCountry->save();
                    $SETTING_GENERAL_ID_CON=$bulkuploadCountry->SETTING_GENERAL_ID;
                }
                else{
                    $SETTING_GENERAL_ID_CON=$countryExits->SETTING_GENERAL_ID;
                }
                    $bulkupload = new SettingGeneral;
                    $bulkupload->SET_PARAM = $element["STATE"];
                    $bulkupload->SET_TYPE = $set_type;
                    $bulkupload->SET_VALUE = $SETTING_GENERAL_ID_CON;
                    $bulkupload->SET_CREATE_BY = $create_by;
                    $bulkupload->save();
             }
             http_response_code(200);
             return response([
                 'message' => 'Data successfully Added.',
                 'data' => $bulkupload
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
			'SET_TYPE' => 'string|nullable',
			'SET_CODE' => 'string|nullable',
			'SET_PARAM' => 'string|nullable',
			'SET_VALUE' => 'integer|nullable',
			'SET_INDEX' => 'integer|nullable',
			'SET_DESCRIPTION' => 'string|nullable',
			'SET_CREATE_BY' => 'integer|nullable',
			'SET_CREATE_TIMESTAMP' => 'integer|nullable'
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
			'SET_PARAM' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //update function
            $data =SettingGeneral::find($request->SETTING_GENERAL_ID);
            $data->SET_PARAM = $request->SET_PARAM;
            $data->SET_CODE = $request->SET_CODE;
            $data->SET_VALUE = $request->SET_VALUE;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated',
                'errorCode' => 4102
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = SettingGeneral::find($request->SETTING_GENERAL_ID);
            $data->delete();


            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete data',
                'errorCode' =>  $th
            ]);
        }
    }

    public function filter(Request $request)
    {

        try {

            $data = DB::table('SETTING_GENERAL  AS SETTING_STATE')
			->select('SETTING_STATE.SET_PARAM', 'SETTING_STATE.SET_VALUE', 'SETTING_COUNTRY.SETTING_GENERAL_ID', 'SETTING_COUNTRY.SET_PARAM')
			->join('SETTING_GENERAL AS SETTING_COUNTRY', 'SETTING_COUNTRY.SETTING_GENERAL_ID', '=', 'SETTING_STATE.SET_VALUE')
            ->where('SETTING_STATE.SET_VALUE',$request->SETTING_GENERAL_ID)
            ->get();

            // $query = SettingGeneral::select()->where('SET_TYPE', '=', 'COUNTRY');
            //     if ($request->SETTING_GENERAL_ID != null) {
            //             $query->where('SETTING_GENERAL_ID', $request->SETTING_GENERAL_ID);

            //     }
            //     $data = $query->get();


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
    public function filterCountry(Request $request)
    {
        try {
            Log::info( "State Data ===>" . $request);
           //dd($request->SETTING_GENERAL_ID);
            //$data = SettingGeneral::where('SET_VALUE', $request->SETTING_GENERAL_ID)->get();
            //if ($request->SETTING_GENERAL_ID != ""){
                Log::info( "State Data tt===>" . $request);
                $data = DB::table('SETTING_GENERAL AS STATE')
                ->select('STATE.SETTING_GENERAL_ID','STATE.SET_PARAM AS SET_STATE', 'COUNTRY.SET_PARAM AS SET_COUNTRY')
                ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
                ->where('STATE.SET_VALUE', '=', $request->SETTING_GENERAL_ID)
                ->get();
                //dd($data);

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

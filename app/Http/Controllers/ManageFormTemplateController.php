<?php

namespace App\Http\Controllers;

use App\Models\ManageFormTemplate;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Validator;
use File;
use Image;
use Compress\Compress;
use App\Helpers\Files;


class ManageFormTemplateController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DB::table('admin_management.MANAGE_FORM_TEMPLATE AS MANAGE_FORM_TEMPLATE')
            ->select('*' )
            ->join('admin_management.MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID')
            ->where('MANAGE_FORM_TEMPLATE.MANAGE_FORM_TEMPLATE_ID',$request->MANAGE_FORM_TEMPLATE_ID)
            ->get();
        //     $data = ManageFormTemplate::select('*')//B::table('MANAGE_FORM_TEMPLATE')
        //    //->select('*')//('MANAGE_FORM_TEMPLATE.MANAGE_FORM_TEMPLATE_ID','MANAGE_FORM_TEMPLATE.TEMP_TITLE','MANAGE_FORM_TEMPLATE.TEMP_DESCRIPTION','','','MANAGE_MODULE.MOD_NAME' )
        //    ->join('MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID')
        //    ->where('MANAGE_FORM_TEMPLATE.MANAGE_FORM_TEMPLATE_ID',$request->MANAGE_FORM_TEMPLATE_ID)

        //    ->first();
        foreach($data as $element){

            if ( $element->FILE_BLOB != null ||  $element->FILE_BLOB !=""){
            $element->FILE_BLOB = base64_encode($element->FILE_BLOB);
            }else{
                $element->FILE_BLOB = "-";
            }
        }
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrievedx.',
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
           $data = DB::table('admin_management.MANAGE_FORM_TEMPLATE AS MANAGE_FORM_TEMPLATE')
           ->select('*' )
           ->join('admin_management.MANAGE_MODULE AS MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID')
           ->get();
           foreach($data as $element){

            if ( $element->FILE_BLOB != null ||  $element->FILE_BLOB !=""){
            $element->FILE_BLOB = base64_encode($element->FILE_BLOB);
            }else{
                $element->FILE_BLOB = "-";
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
            ],400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_MODULE_ID' => 'required|integer', //Cuti raya cina
            'TEMP_TITLE' => 'required|string', //2021-02-13
            'TEMP_DESCRIPTION' => 'required|string', //2021-02-14
            //'FILEOBJECT' => 'file'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //save into db
            $data = new ManageFormTemplate;
            $data->MANAGE_MODULE_ID = $request->MANAGE_MODULE_ID;
            $data->TEMP_TITLE = $request->TEMP_TITLE;
            $data->TEMP_DESCRIPTION = $request->TEMP_DESCRIPTION;
            if ($request->file('FILEOBJECT') != null) {
                $file = $request->file('FILEOBJECT');
                $blob = $file->openFile()->fread($file->getSize());
                //Log::info( "blob ===>" . $blob);
                $fileSize = $file->getSize();
                $data->FILE_BLOB = $blob;
                $data->FILE_MIMETYPE = $file->getMimeType();
                $data->TEMP_FILENAME = $file->getClientOriginalName();
                $data->TEMP_FILEEXTENSION = $file->getClientOriginalExtension();
                $data->TEMP_FILESIZE = $fileSize;
            }
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

    public function getFile(Request $request)
    {
        $data = ManageFormTemplate::find($request->MANAGE_FORM_TEMPLATE_ID);
        $filePath = $data->TEMP_FILEPATH . '/' . $data->MANAGE_FORM_TEMPLATE_ID . '_' . $data->TEMP_FILENAME;
        return response()->download($filePath);
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
       
        try {
            $data = ManageFormTemplate::find($request->MANAGE_FORM_TEMPLATE_ID);
            // $filePath = $data->TEMP_FILEPATH . '/' . $data->MANAGE_FORM_TEMPLATE_ID . '_' . $data->TEMP_TITLE . '.'. $data->TEMP_FILEEXTENSION;
            // if($request->file('FILEOBJECT') != null){
            //     if(File::exists($filePath)){
            //         unlink($filePath);
            //     }
            //     $file = $request->file('FILEOBJECT');
            //     $fileSize = $file->getSize();
            //     $destinationPath = storage_path('app/public/global/template');
            //     $filenametostore = $data->MANAGE_FORM_TEMPLATE_ID . '_' . $request->TEMP_TITLE . '.' . $file->getClientOriginalExtension();
            //     $file->move($destinationPath, $filenametostore);

                $data->MANAGE_MODULE_ID = $request->MANAGE_MODULE_ID;
                $data->TEMP_TITLE = $request->TEMP_TITLE;
                $data->TEMP_DESCRIPTION = $request->TEMP_DESCRIPTION;
                if ($request->file('FILEOBJECT') != null) {
                    $file = $request->file('FILEOBJECT');
                    $blob = $file->openFile()->fread($file->getSize());
                    //Log::info( "blob ===>" . $blob);
                    $fileSize = $file->getSize();
                    $data->FILE_BLOB = $blob;
                    $data->FILE_MIMETYPE = $file->getMimeType();
                    $data->TEMP_FILENAME = $file->getClientOriginalName();
                    $data->TEMP_FILEEXTENSION = $file->getClientOriginalExtension();
                    $data->TEMP_FILESIZE = $fileSize;
                }
                $data->save();
                http_response_code(200);
                return response([
                    'message' => 'Data succesfully updated'
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
            //**find template by id*/
            $data = ManageFormTemplate::find($request->MANAGE_FORM_TEMPLATE_ID);
            //FIXME: I kept the same path as create method. Maybe we can change it future..
            $filePath = $data->TEMP_FILEPATH . '/' . $data->MANAGE_FORM_TEMPLATE_ID . '_' . $data->TEMP_TITLE . '.'. $data->TEMP_FILEEXTENSION;
            if(File::exists($filePath)){
                unlink($filePath);
            }else{
                //In some case the old template, in case file not exists, but entry exists in db..
                //so that, it has chance to remove from db.
                if( !$data->MANAGE_FORM_TEMPLATE_ID ){
                    http_response_code(400);
                    return response([
                        'message' => 'File not exist',
                        'errorCode' => 4107
                    ],400);
                }
            }

            //**delete from db */
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

    public function fileDownload(Request $request){
        $validator = Validator::make($request->all(), [
            'MANAGE_FORM_TEMPLATE_ID' => 'integer',
        ]);
        $data = ManageFormTemplate::where('MANAGE_FORM_TEMPLATE_ID', '=', $request->input('id'))->first();
        $name = $data->MANAGE_FORM_TEMPLATE_ID . '_' . $data->TEMP_TITLE . '.'. $data->TEMP_FILEEXTENSION;
        $filePath = $data->TEMP_FILEPATH . '/' . $name;
        if(File::exists($filePath)){
            return response()->download(
                $filePath,
                $name
            );
        }
        else{
                http_response_code(400);
                return response([
                'message' => 'File not exist',
                'errorCode' => 4107
                ],400);
        }
    }

    public function fileDownload1(Request $request){
        $validator = Validator::make($request->all(), [
            'MANAGE_FORM_TEMPLATE_ID' => 'integer',
        ]);
        $data = ManageFormTemplate::select('FILE_BLOB')->where('MANAGE_FORM_TEMPLATE_ID', '=', $request->input('id'))->first();
        http_response_code(200);
        return response([
            'message' => 'All data successfully retrieved.',
            'data' => $data
        ]);
       
    }

    public function filter(Request $request)
    {
        try {

            $data = ManageFormTemplate::select('*')
            ->select('MANAGE_FORM_TEMPLATE.MANAGE_FORM_TEMPLATE_ID','MANAGE_FORM_TEMPLATE.TEMP_TITLE','MANAGE_FORM_TEMPLATE.TEMP_DESCRIPTION','MANAGE_MODULE.MOD_NAME' )
            ->join('MANAGE_MODULE', 'MANAGE_MODULE.MANAGE_MODULE_ID', '=', 'MANAGE_FORM_TEMPLATE.MANAGE_MODULE_ID')->where('MANAGE_MODULE.MANAGE_MODULE_ID', $request->MANAGE_MODULE_ID)->get();
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

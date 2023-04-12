<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Demo;
use App\Models\DemoDocument;
use App\Models\Module;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\FileReader;
use App\Helpers\FileUpload;
use App\Helpers\CurrentUser;
use App\Helpers\ManageNotification;
use Illuminate\Support\Facades\Log;
class DemoController extends Controller
{
    public function createuser(Request $request)
    {
        $user = new CurrentUser();
        $result = $user->createUser($request);

        dd($result);
        http_response_code(200);
        return response([
        'message' => 'User successfully created.',
    ]);
    }

    public function getRequest(Request $request)
    {
        return $request->DATA;
    }
    public function getNotification(Request $request)
    {
        $user = new ManageNotification();
        return $read = $user->read($request->MANAGE_GROUP_ID);
    }

    public function assignGroup(Request $request)
    {
        $keycloakId = $request->userId;
        $group = $request->group; //1 : FiMM User , 2 : Distributor , 3 : Consultant , 4 : Training Provider , 5 : Third Party
        $user = new CurrentUser();
        $result = $user->addToMainGroup($keycloakId,$group);
        http_response_code(200);
        return response([
        'message' => 'Group successfully assigned to user.',
    ]);
    }
    
    public function join(Request $request)
    {

        $join_sample = DB::table('admin_management.USER AS user')
        ->select('user.*','user_address.USER_ADDR_1','user_address.USER_ADDR_2','user_address.USER_ADDR_3','suspension.SUSP_DATE_START')
        ->join('admin_management.USER_ADDRESS AS user_address', 'user.USER_ID', '=', 'user_address.USER_ID') //join
        ->join('distributor_management.SUSPENSION AS suspension', 'user.USER_ID', '=', 'suspension.FIMM_USER_ID') //join
        ->where('suspension.FIMM_USER_ID', 1)
        ->get();

        return $join_sample;

        //url sample : http://localhost:7000/api/module0/demo-join
    }

    public function storeDemo(Request $request) {
        $demo = new Demo();
        $demo->make = $request->make;
        $demo->model = $request->model;
        $demo->save();

        return $demo;
    }

    public function resetPassword(Request $request) {
        
        $user = new CurrentUser();

        $result = $user->resetPassword($request);

        return $result;
    }

    public function uploadFile(Request $request) {
        $file = $request->file;
        foreach($file as $item){
            $converter = new FileUpload();
            // $itemFile->getClientOriginalName();
            // $itemFile->getSize();
            // $itemFile->getClientOriginalExtension();
            // $itemFile->getMimeType();

            $blob = $item->openFile()->fread($item->getSize()); //convert ke blob
            $demo = new DemoDocument;
            $demo->doc = $blob;
            $demo->data = $item->getClientOriginalName();//$request->data;
            $demo->save();
        }
    }



    public function callOtherModules(Request $request) {

        $token = $request->bearerToken();
        $module = $request->id;

        $response = Curl::to('http://localhost:7001/api/module1/distributor_user')
            ->withBearer($token)
            ->get();

        return $response;
    }

    public function getDemos(Request $request) {
        $demos = Demo::all();

        return $demos;
    }

    public  function editDemo(Request $request, $id){
        $demo = Demo::where('id',$id)->first();

        $demo->make = $request->get('val_1');
        $demo->model = $request->get('val_2');
        $demo->save();

        return $demo;
    }

    public function deleteDemo(Request $request){
        $demo = Demo::find($request->id)->delete();
    }
    public function createDummyDistributor(Request $request)
    {
        Log::info("test" . $request);
        try {
             DB::enableQueryLog();
             $distvalues = array('DIST_NAME' => $request->DIST_NAME,'DIST_CODE' => 0);
             $distId = DB::table('distributor_management.DISTRIBUTOR')->insertGetId($distvalues);
            // Log::info("lastId". $data);
             $typevalues = array('DIST_ID' => $distId,'DIST_TYPE' => $request->DIST_TYPE);
             $data1 = DB::table('distributor_management.DISTRIBUTOR_TYPE')->insert($typevalues);
            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ], 400);
        }
    }

    public function getDummyDistributor(Request $request)
    {
        try {
            DB::enableQueryLog();

            $data = DB::table('distributor_management.DISTRIBUTOR AS DISTRI')
            ->select('DISTRI.DISTRIBUTOR_ID as DISTRIBUTOR_ID', 'DISTRI.DIST_NAME as DIST_NAME', 'ADMIN_DIST_TYPE.DISTRIBUTOR_TYPE_ID as DISTRIBUTOR_TYPE_ID', 'ADMIN_DIST_TYPE.DIST_TYPE_NAME as DIST_TYPE_NAME', 'DIST_TYPE.DIST_TYPE_ID as DIST_TYPE_ID')
            ->where('DISTRI.DIST_CODE', '=', 0)
            ->leftJoin('distributor_management.DISTRIBUTOR_TYPE as DIST_TYPE', 'DISTRI.DISTRIBUTOR_ID', '=', 'DIST_TYPE.DIST_ID')
            ->leftJoin('admin_management.DISTRIBUTOR_TYPE as ADMIN_DIST_TYPE', 'DIST_TYPE.DIST_TYPE', '=', 'ADMIN_DIST_TYPE.DISTRIBUTOR_TYPE_ID')
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

    public function deleteDummyDistributor(Request $request)
    {
        try {
            $data=DB::table('distributor_management.DISTRIBUTOR as DISTRIBUTOR')->where('DISTRIBUTOR.DISTRIBUTOR_ID', $request->DISTRIBUTOR_ID)->delete();

            $datatype=DB::table('distributor_management.DISTRIBUTOR_TYPE as DISTRIBUTOR_TYPE')->where('DISTRIBUTOR_TYPE.DIST_ID', $request->DISTRIBUTOR_ID)->delete();
            http_response_code(200);
            return response([
            'message' => 'Data successfully deleted1.'
        ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Data failed to be deleted.',
            'errorCode' => 4102
        ], 400);
        }
    }

    public function updateDummyDistributor(Request $request)
    {
        try {
            DB::enableQueryLog();
            $update=DB::table('distributor_management.DISTRIBUTOR as DISTRIBUTOR')->where('DISTRIBUTOR.DISTRIBUTOR_ID', $request->DISTRIBUTOR_ID)->update(['DISTRIBUTOR.DIST_NAME' => $request->DIST_NAME,'DISTRIBUTOR.DIST_CODE' => 0]);

            $update=DB::table('distributor_management.DISTRIBUTOR_TYPE as DISTRIBUTOR_TYPE')->where('DISTRIBUTOR_TYPE.DIST_ID', $request->DISTRIBUTOR_ID)->update(['DISTRIBUTOR_TYPE.DIST_TYPE' =>$request->DIST_TYPE]);


            // $data = Distributor::find($request->DISTRIBUTOR_ID);
            // $data->DIST_NAME = $request->DIST_NAME;
            // $data->DIST_CODE = 0;
            // $data->save();

            // $dataDistType = DistributorType::find($request->DIST_TYPE_ID);
            // // $dataDistType->DIST_ID = $data->DISTRIBUTOR_ID;
            // $dataDistType->DIST_TYPE = $request->DIST_TYPE;
            // $dataDistType->save();

            // dd(DB::getQueryLog());
            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ], 400);
        }
    }
}

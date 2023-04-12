<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\Notification;
use App\Helpers\ManageNotification;
use App\Helpers\ManageDistributorNotification;
use App\Helpers\ManageConsultantNotification;
use App\Helpers\ManageOthersNotification;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class notificationList
{

}
class NotificationController extends Controller
{
    public function get(Request $request)
    {
        try {
            $notification = new ManageNotification();

            $result = $notification->read($request->NOTIFICATION_RECEIVER_ID);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $result
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function update(Request $request)
    {
        try {
            $updatenotification = new ManageNotification();

            $result = $updatenotification->update($request->NOTIFICATION_ID);

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 0
            ]);
        }
    }

    public function getDistributor(Request $request)
    {
        try {
            // dd($request->NOTIFICATION_RECEIVER_ID);
            $user = DB::table('distributor_management.USER AS A')
            ->select ('A.USER_DIST_ID','A.USER_GROUP')
            ->where('A.USER_ID',$request->NOTIFICATION_RECEIVER_ID)
            ->first();

            // dd($user);

            $notification = new ManageDistributorNotification();

            $result = $notification->read($user->USER_GROUP,$user->USER_DIST_ID);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $result
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function updateDistributor(Request $request)
    {
        try {
            $updatenotiDist = new ManageDistributorNotification();

            $result = $updatenotiDist->update($request->NOTIFICATION_ID);

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 0
            ]);
        }
    }
    public function getOthers(Request $request)
    {
        try {
            // dd($request->NOTIFICATION_RECEIVER_ID);
            $user = DB::table('funds_management.TP_USER AS A')
            ->select ('A.TP_USER_ID','A.TP_USER_GROUP')
            ->where('A.TP_USER_ID',$request->NOTIFICATION_RECEIVER_ID)
            ->first();

            // dd($user);

            $notification = new ManageDistributorNotification();

            $result = $notification->read($user->USER_GROUP,$user->USER_DIST_ID);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $result
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function updateOthers(Request $request)
    {
        try {
            $updatenotiOthers = new ManageOthersNotification();

            $result = $updatenotiOthers->update($request->NOTIFICATION_ID);

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 0
            ]);
        }
    }

    public function add(Request $request)
    {
        try {
            $notification = new ManageNotification();

            $add = $notification->add($request->MANAGE_GROUP_ID,$request->PROCESS_FLOW_ID);

            http_response_code(200);
            return response([
                'message' => 'Notification successfully added.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function getConsultant(Request $request)
    {
        try {
            $user = DB::table('consultant_management.USER AS A')
            ->select ('B.CONSULTANT_ID','A.USER_GROUP')
            ->join('consultant_management.CONSULTANT AS B', 'B.USER_ID', '=', 'A.USER_ID')
            ->where('A.USER_ID',$request->_RECEIVER_ID)
            ->first();

            $notification = new ManageConsultantNotification();

            $result = $notification->read($user->USER_GROUP,$user->CONSULTANT_ID);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $result
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function updateConsultant(Request $request)
    {
        try {
            $updatenotiConst = new ManageConsultantNotification();

            $result = $updatenotiConst->update($request->NOTIFICATION_ID);

            http_response_code(200);
            return response([
                'message' => 'Data successfully read.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 0
            ]);
        }
    }

    public function getByModuleAndGroupId(Request $request)
    {
        try {
            $notification = new ManageNotification();

            $result = $notification->readForEsc(
                $request->NOTIFICATION_RECEIVER_ID,
                $request->MODULE,
            );

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $result
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }
}

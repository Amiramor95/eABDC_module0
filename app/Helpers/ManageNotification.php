<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection= 'module0';

    protected $table = 'NOTIFICATION';
    protected $primaryKey = 'NOTIFICATION_ID';

    public $timestamps =false;
    use HasFactory;

}

class NotificationType extends Model
{
    protected $connection= 'module0';

    protected $table = 'NOTIFICATION_TYPE';

    public $timestamps =false;
    use HasFactory;

}

class notificationList
{

}

class ManageNotification
{
    public function add($groupId,$flowId,$notiRemark,$notiLoc)
    {
        $group = new Notification;
        $group->NOTIFICATION_GROUP_ID = $groupId; //group Id Refer MANAGE_GROUP table under admin management database
        $group->PROCESS_FLOW_ID = $flowId;//type (1,2,..) Refer PROCESS_FLOW table under admin management database
        $group->REMARK = $notiRemark ; //NOTIFICATION REMARK
        $group->LOCATION = $notiLoc; // TO OPEN WHICH ROUTE
        $group->save();
    }

    public function read($groupId)
    {
        try {
            $notificationArray = array();

            $notifications = Notification::where('NOTIFICATION_GROUP_ID', $groupId)
                    ->join('admin_management.PROCESS_FLOW AS processFlow',
                    'processFlow.PROCESS_FLOW_ID', '=', 'NOTIFICATION.PROCESS_FLOW_ID')
                    ->orderBy('NOTIFICATION.NOTIFICATION_ID','DESC')
                    ->get();

            $i = 0;
            foreach ($notifications as $notification) {

                // $message = $notification->REMARK;
                // $route =  $notification->LOCATION;

                // $e = new notificationList;
                // $e->message = $message;
                // $e->route = $route;
                // $notificationArray[] = $e;

                $notiID = $notification-> NOTIFICATION_ID;
                $message = $notification->REMARK;
                $route = $notification->LOCATION;

                $e = new notificationList;
                $e->notiID = $notiID;
                $e->message = $message;
                $e->route = $route;
                $notificationArray[] = $e;

                $i++;
            }

            return $notificationArray;

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }


    }

    public function update($notiID)
    {
        $update= Notification::find($notiID);
        $update->delete();

    }


    public function readForEsc($groupId,$module)
    {
        try {
            $notificationArray = array();
            $PROCESS_FLOW = ['ESC PROFILE (ESC PROVIDER)','ESC PROFILE (ESC ADMIN)'];
            $notifications = Notification::where('NOTIFICATION_GROUP_ID', $groupId)
                ->join('admin_management.PROCESS_FLOW AS processFlow',
                    'processFlow.PROCESS_FLOW_ID', '=', 'NOTIFICATION.PROCESS_FLOW_ID')
                ->where('processFlow.MODULE_ID',$module)
                ->whereIn('processFlow.PROCESS_FLOW_NAME',$PROCESS_FLOW)
                ->orderBy('NOTIFICATION.NOTIFICATION_ID','DESC')
                ->get();
            $i = 0;
            foreach ($notifications as $notification) {

                $message = $notification->REMARK;
                $route =  $notification->LOCATION;

                $e = new notificationList;
                $e->message = $message;
                $e->route = $route;
                $notificationArray[] = $e;

                $i++;
            }

            return $notificationArray;

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ],400);
        }
    }
}

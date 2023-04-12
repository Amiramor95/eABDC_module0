<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantNotification extends Model
{
    protected $connection= 'module0';

    protected $table = 'CONSULTANT_NOTIFICATION';

    protected $primaryKey = 'CONSULTANT_NOTIFICATION_ID';

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

class ManageConsultantNotification

{
    public function add($groupId,$flowId,$constId,$notiRemark,$notiLoc)
    {
        $group = new ConsultantNotification;
        $group->NOTIFICATION_GROUP_ID = $groupId; //group Id Refer CONSULTANT_MANAGE_GROUP table under admin management database
        $group->PROCESS_FLOW_ID = $flowId;//type (1,2,..) Refer PROCESS_FLOW table under admin management database
        $group->CONSULTANT_ID = $constId;
        $group->REMARK = $notiRemark ; //NOTIFICATION REMARK
        $group->LOCATION = $notiLoc; // TO OPEN WHICH ROUTE
        $group->save();
    }

    public function read($groupId,$consultantId)
    {
        try {
            $notificationArray = array();

            $notifications = ConsultantNotification::where('NOTIFICATION_GROUP_ID', $groupId)
                             ->where('CONSULTANT_ID', $consultantId)
                             ->where('NOTIFICATION_STATUS', 0)
                             ->orderBy('CONSULTANT_NOTIFICATION_ID', 'DESC')
                             ->join('admin_management.PROCESS_FLOW AS processFlow', 
                             'processFlow.PROCESS_FLOW_ID', '=', 'CONSULTANT_NOTIFICATION.PROCESS_FLOW_ID')
                             ->get();

            $i = 0;
            foreach ($notifications as $notification) {

                $notiID = $notification-> CONSULTANT_NOTIFICATION_ID;
                $message = $notification->REMARK;
                $route = $notification->LOCATION;

                $e = new notificationList;
                $e->notiID = $notiID;
                $e->message = $message;
                $e->route = $route;
                $notificationArray[] = $e;
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
        $update= ConsultantNotification::find($notiID);
        $update->delete();

    }
}

<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenAccess extends Model
{
    protected $connection= 'module0';

    protected $table = 'MANAGE_SCREEN_ACCESS';

    public $timestamps =false;
    use HasFactory;

}
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
    public function add($groupId,$flowId)
    {
        $group = new Notification;
        $group->NOTIFICATION_GROUP_ID = $groupId; //group Id Refer MANAGE_GROUP table under admin management database
        $group->PROCESS_FLOW_ID = $flowId; //type (1,2,..) Refer PROCESS_FLOW table under admin management database
        $group->save();

        return $group;
    }

    public function read($groupId)
    {
        try {

            //dd($groupId);

            $notificationArray = array();

            $screenAccess = ScreenAccess::where('MANAGE_GROUP_ID', $groupId)->get();
           //dd( $screenAccess);

            $notifications = Notification::where('NOTIFICATION_GROUP_ID', $groupId)
                             ->where('NOTIFICATION_STATUS', 0)
                             ->orderBy('NOTIFICATION_ID', 'DESC')
                             //->join('admin_management.MANAGE_SCREEN_ACCESS AS manageScreenAccess','manageScreenAccess.MANAGE_GROUP_ID', '=', 'NOTIFICATION.NOTIFICATION_GROUP_ID')
                            // ->join('admin_management.PROCESS_FLOW AS processFlow','processFlow.PROCESS_FLOW_ID', '=', 'NOTIFICATION.PROCESS_FLOW_ID')
                             //->join('admin_management.MANAGE_SCREEN AS manageScreen','manageScreen.SCREEN_PROCESS', '=', 'NOTIFICATION.PROCESS_FLOW_ID')
                      ->get();

           //dd( $notifications);

            $i = 0;
            foreach ($notifications as $notification) {

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
}

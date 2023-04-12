<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use Session;

class AutoLogout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will Auto Logout User after 12 hours inactivity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $lastlogtime = $now->format('Y-m-d H:i:s');
        $idleSession = DB::table('admin_management.LOGIN_IDLE_SESSION AS IDLE')
        ->select('IDLE.LOGIN_IDLE_SESSION_MIN AS LOGIN_IDLE_SESSION_MIN')
        ->orderBy('IDLE.LOGIN_IDLE_SESSION_ID', 'desc')
        ->first();
        $sessionidletime = $idleSession->LOGIN_IDLE_SESSION_MIN ?? config('session.lifetime');
        // Fimm User List
        $fimm_user = DB::table('admin_management.USER AS AUSER')
        ->select('AUSER.USER_ID AS USER_ID','AUSER.LAST_SEEN_AT AS LAST_SEEN_AT','AUSER.ISLOGIN AS ISLOGIN')
        ->where('AUSER.ISLOGIN','=',1)
        ->get();
        // Distributor User List
        $dist_user = DB::table('distributor_management.USER AS DUSER')
        ->select('DUSER.USER_ID AS USER_ID','DUSER.LAST_SEEN_AT AS LAST_SEEN_AT','DUSER.ISLOGIN AS ISLOGIN')
        ->where('DUSER.ISLOGIN','=',1)
        ->get();
         // Consultant User List
         $con_user = DB::table('consultant_management.USER AS CUSER')
         ->select('CUSER.USER_ID AS USER_ID','CUSER.LAST_SEEN_AT AS LAST_SEEN_AT','CUSER.ISLOGIN AS ISLOGIN')
         ->where('CUSER.ISLOGIN','=',1)
         ->get();

          // Others User List
          $tp_user = DB::table('funds_management.TP_USER AS TUSER')
          ->select('TUSER.TP_USER_ID AS USER_ID','TUSER.LAST_SEEN_AT AS LAST_SEEN_AT','TUSER.ISLOGIN AS ISLOGIN')
          ->where('TUSER.ISLOGIN','=',1)
          ->get();

          // ESC User List
          $esc_user = DB::table('exam_booking.ESC_USER AS EUSER')
          ->select('EUSER.ESC_USER_ID AS USER_ID','EUSER.LAST_SEEN_AT AS LAST_SEEN_AT','EUSER.ISLOGIN AS ISLOGIN')
          ->where('EUSER.ISLOGIN','=',1)
          ->get();

        try{
            foreach($fimm_user as $fuser)
            {
                $last_seen = Carbon::parse($fuser->LAST_SEEN_AT);
                $absence = $last_seen->diffInMinutes($now,true);
                if($absence > $sessionidletime) {//$sessionidletime
                $updatedata = DB::table('admin_management.USER as AMUSER')->where('AMUSER.USER_ID','=', $fuser->USER_ID)->update(['AMUSER.ISLOGIN' => 0]);

                $updatelog=DB::table('admin_management.FIMM_USER_LOG as FIMMLOG')
                ->where('FIMMLOG.USER_ID','=', $fuser->USER_ID)
                ->update(['FIMMLOG.LOGOUT_TIMESTAMP' => $lastlogtime,'FIMMLOG.STATUS' =>0]);

                  session()->flush();
                }
            }
            foreach($dist_user as $duser)
            {
                $last_seen1 = Carbon::parse($duser->LAST_SEEN_AT);
                $absence1 = $last_seen1->diffInMinutes($now,true);
                if($absence1 > $sessionidletime) {//$sessionidletime
                $updatedata1 = DB::table('distributor_management.USER as DMUSER')->where('DMUSER.USER_ID','=', $duser->USER_ID)->update(['DMUSER.ISLOGIN' => 0]);

                $updatelog1=DB::table('admin_management.DISTRIBUTOR_USER_LOG as DISTLOG')
                ->where('DISTLOG.USER_ID','=', $duser->USER_ID)
                ->update(['DISTLOG.LOGOUT_TIMESTAMP' => $lastlogtime,'DISTLOG.STATUS' =>0]);

                  session()->flush();
                }
            }
            foreach($con_user as $cuser)
            {
                $last_seen2 = Carbon::parse($cuser->LAST_SEEN_AT);
                $absence2 = $last_seen2->diffInMinutes($now,true);
                if($absence2 > $sessionidletime) {//$sessionidletime
                $updatedata2 = DB::table('consultant_management.USER as CMUSER')->where('CMUSER.USER_ID','=', $cuser->USER_ID)->update(['CMUSER.ISLOGIN' => 0]);

                $updatelog2=DB::table('admin_management.CONSULTANT_USER_LOG as CONTLOG')
                ->where('CONTLOG.USER_ID','=', $cuser->USER_ID)
                ->update(['CONTLOG.LOGOUT_TIMESTAMP' => $lastlogtime,'CONTLOG.STATUS' =>0]);
                  session()->flush();
                }
            }
            foreach($tp_user as $tuser)
            {
                $last_seen3 = Carbon::parse($tuser->LAST_SEEN_AT);
                $absence3 = $last_seen3->diffInMinutes($now,true);
                if($absence3 > $sessionidletime) {//$sessionidletime
                $updatedata3 = DB::table('funds_management.TP_USER as TMUSER')->where('TMUSER.TP_USER_ID','=', $tuser->USER_ID)->update(['TMUSER.ISLOGIN' => 0]);
                $updatelog3=DB::table('admin_management.OTHERS_USER_LOG as OTHERLOG')
                ->where('OTHERLOG.USER_ID','=', $tuser->USER_ID)
                ->update(['OTHERLOG.LOGOUT_TIMESTAMP' => $lastlogtime,'OTHERLOG.STATUS' =>0]);
                  session()->flush();
                }
            }
            foreach($esc_user as $euser)
            {
                $last_seen4 = Carbon::parse($euser->LAST_SEEN_AT);
                $absence4 = $last_seen4->diffInMinutes($now,true);
                if($absence4 > $sessionidletime) {//$sessionidletime
                $updatedata4 = DB::table('exam_booking.ESC_USER as ESC_USER')->where('ESC_USER.ESC_USER_ID','=', $euser->USER_ID)->update(['ESC_USER.ISLOGIN' => 0]);
                
                $updatelog4=DB::table('admin_management.EXAM_BOOKING_USER_LOG as EXAM_BOOKING_USER_LOG')
                ->where('EXAM_BOOKING_USER_LOG.USER_ID','=', $euser->USER_ID)
                ->update(['EXAM_BOOKING_USER_LOG.LOGOUT_TIMESTAMP' => $lastlogtime,'EXAM_BOOKING_USER_LOG.STATUS' =>0]);
                  session()->flush();
                }
            }
            echo 'Command Operation Successfull';
            // Log::info("ok");
               return 1;//ok
         }catch(RequestException $e){
            return "0 " . $e->errorInfo; //some error
         }
    }
}

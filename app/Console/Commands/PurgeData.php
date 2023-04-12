<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurgeDataPeriod;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use DB;

class PurgeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:purge-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data Purge For Distributor , Consultant, Third party, Training Provider';

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

        try{
            $data = PurgeDataPeriod::first();
            $dist = $data->DIST_DURATION;
            $const = $data->CONST_DURATION;
            $third = $data->THIRD_DURATION;
            $tp = $data->TP_DURATION;
            
            //Distributor Data Purge
            $dist_user = DB::table('distributor_management.USER')
                ->where('USER_ISLOGIN',0)->get(); 
            $dist_arr = [];    
            foreach($dist_user as $dUser){
                if($dUser->LAST_SEEN_AT){
                    $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                    $from = Carbon::createFromFormat('Y-m-d H:s:i', $dUser->LAST_SEEN_AT);
                    $dist_month = $to->diffInMonths($from);
                    if($dist_month >= $dist){
                        $dist_arr[] = DB::table('distributor_management.USER')
                                        ->where('USER_ID',$dUser->USER_ID)->delete();
                    }
                }   
            }

            //Consultant Data Purge
            $const_user = DB::table('consultant_management.USER')
                ->where('USER_ISLOGIN',0)->get(); 
            $dist_arr = [];    
            foreach($const_user as $cUser){
                if($cUser->LAST_SEEN_AT){
                    $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                    $from = Carbon::createFromFormat('Y-m-d H:s:i', $cUser->LAST_SEEN_AT);
                    $const_month = $to->diffInMonths($from);
                    if($const_month >= $const){
                        $dist_arr[] = DB::table('consultant_management.USER')
                                        ->where('USER_ID',$cUser->USER_ID)->delete();
                    }
                }   
            }

            //Training Provider Data Purge
            $tp_user = DB::table('funds_management.TP_USER')
                        ->where('TP_ISLOGIN',0)->where('TP_USER_TYPE',2)->get(); 
            $dist_arr = [];    
            foreach($tp_user as $tpUser){
                if($tpUser->LAST_SEEN_AT){
                    $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                    $from = Carbon::createFromFormat('Y-m-d H:s:i', $tpUser->LAST_SEEN_AT);
                    $tp_month = $to->diffInMonths($from);
                    if($tp_month >= $tp){
                        $dist_arr[] = DB::table('funds_management.TP_USER')
                                        ->where('TP_USER_ID',$tpUser->TP_USER_ID)->delete();
                    }
                }   
            }

            //3rd Party Data Purge
            $third_user = DB::table('funds_management.TP_USER')
            ->where('TP_ISLOGIN',0)->where('TP_USER_TYPE',1)->get(); 
            $dist_arr = [];    
            foreach($third_user as $thirdUser){
                if($thirdUser->LAST_SEEN_AT){
                $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                $from = Carbon::createFromFormat('Y-m-d H:s:i', $thirdUser->LAST_SEEN_AT);
                $third_month = $to->diffInMonths($from);
                if($third_month >= $third){
                    $dist_arr[] = DB::table('funds_management.TP_USER')
                        ->where('TP_USER_ID',$thirdUser->TP_USER_ID)->delete();
                }
                }
            }

            //print_r($dist_arr); 
            echo '</br>Command Operation Successfull';
            return 1;//ok
         }catch(RequestException $e){
            return "0 " . $e->errorInfo; //some error
         }
        
    }
}

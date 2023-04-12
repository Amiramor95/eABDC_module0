<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurgeDataPeriod;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use DB;

class InactiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactive:user-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command turn on off for users active/inactive';

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
        $to = Carbon::now();
        $setting_data = DB::table('USER_ACTIVE_INACTIVE')->get();
        foreach($setting_data as $data){

            //FiMM Data Inactive
            if($data->TYPE == 1 && $data->IS_ACTIVE == 1){
                $fimm_user = DB::table('admin_management.USER')->get(); 
                $dist_arr = [];    
                foreach($fimm_user as $fUser){
                    if($fUser->LAST_SEEN_AT){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                        $from = Carbon::createFromFormat('Y-m-d H:s:i', $fUser->LAST_SEEN_AT);
                        $fimm_day = $to->diffInDays($from);
                        if($fimm_day >= $data->DURATION){
                            $dist_arr[] = DB::table('distributor_management.USER')
                                    ->where('USER_ID',$fUser->USER_ID)->update([
                                        'USER_STATUS' => 0
                                    ]);
                        }
                    }   
                }
            }
            //Distributor Data Inactive
            if($data->TYPE == 2 && $data->IS_ACTIVE == 1){
                $dist_user = DB::table('distributor_management.USER')->get(); 
                $dist_arr = [];    
                foreach($dist_user as $dUser){
                    if($dUser->LAST_SEEN_AT){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                        $from = Carbon::createFromFormat('Y-m-d H:s:i', $dUser->LAST_SEEN_AT);
                        $dist_day = $to->diffInDays($from);
                        if($dist_day >= $data->DURATION){
                            $dist_arr[] = DB::table('distributor_management.USER')
                                ->where('USER_ID',$dUser->USER_ID)->update([
                                    'USER_STATUS' => 2
                                ]);
                        }
                    }   
                }
            }
            //Consultant Data Inactive
            if($data->TYPE == 3 && $data->IS_ACTIVE == 1){
                $cons_user = DB::table('consultant_management.USER')->get(); 
                $cons_arr = [];    
                foreach($cons_user as $cUser){
                    if($cUser->LAST_SEEN_AT){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                        $from = Carbon::createFromFormat('Y-m-d H:s:i', $cUser->LAST_SEEN_AT);
                        $cons_day = $to->diffInDays($from);
                        if($cons_day >= $data->DURATION){
                            $cons_arr[] = DB::table('distributor_management.USER')
                                    ->where('USER_ID',$cUser->USER_ID)->update([
                                        'USER_STATUS' => 0
                                    ]);
                        }
                    }   
                }
            }

            //Consultant Data Inactive
            // if($data->TYPE == 3 && $data->IS_ACTIVE == 1){
            //     $cons_user = DB::table('consultant_management.USER')->get(); 
            //     $cons_arr = [];    
            //     foreach($cons_user as $cUser){
            //         if($cUser->LAST_SEEN_AT){
            //             $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
            //             $from = Carbon::createFromFormat('Y-m-d H:s:i', $cUser->LAST_SEEN_AT);
            //             $cons_day = $to->diffInDays($from);
            //             if($cons_day >= $data->DURATION){
            //                 $cons_arr[] = DB::table('distributor_management.USER')
            //                                 ->where('USER_ID',$cUser->USER_ID)->first();
            //             }
            //         }   
            //     }
            // }

            //TP Data Inactive
            if($data->TYPE == 5 && $data->IS_ACTIVE == 1){
                $tp_user = DB::table('funds_management.TP_USER')->get(); 
                $tp_arr = [];    
                foreach($tp_user as $tpUser){
                    if($tpUser->LAST_SEEN_AT){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                        $from = Carbon::createFromFormat('Y-m-d H:s:i', $tpUser->LAST_SEEN_AT);
                        $tp_day = $to->diffInDays($from);
                        if($tp_day >= $data->DURATION){
                            $tp_arr[] = DB::table('distributor_management.USER')
                                ->where('TP_USER_ID',$tpUser->USER_ID)->update([
                                    'TP_STATUS' => 0
                                ]);
                        }
                    }   
                }
            }
        }

        print_r($dist_arr);
        return 0;
    }
}

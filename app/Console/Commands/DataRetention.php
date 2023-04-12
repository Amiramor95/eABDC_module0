<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use DB;
use File;

class DataRetention extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retention:data-retention';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will retention the database of Distributor, Consultant, CPD, Anmual Fee ';

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
        $get_retention = DB::table('DATA_RETENTION')->first();
        //$filename = "backup-".date("d-m-Y-H-i-s").".sql";
        $mysqlPath = env('MYSQL_DUMP_PATH'); //"D:\ibcs-project\mysql\bin\mysqldump";
        $database_name = [
            'distributor_management',
            'consultant_management',
            'cpd_management',
            'annualFee_management'
        ];
        
        try{
            $from = Carbon::createFromFormat('Y-m-d H:s:i', $get_retention->UPDATED_AT);
            $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
            $dist_year = $to->diffInYears($from);
            if($dist_year >=  $get_retention->RETENTION_DURATION){
                $path = public_path('data-retention/'. date("d-m-Y-H-i-s"));
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }
                foreach($database_name as $data_name){
                    $filename = $data_name . ".sql";
                    $command = "$mysqlPath --user=" 
                    . env('DB_USERNAME') 
                    ." --password=" 
                    . env('DB_PASSWORD') 
                    . " --host=" 
                    . env('DB_HOST') 
                    . " " . $data_name . "  > " 
                    . $path . "/" 
                    . $filename."  2>&1";
                    $returnVar = NULL;
                    $output  = NULL;
                    //exec($command, $output, $returnVar);
                }
                // Update the last backup date
                DB::table('DATA_RETENTION')->update([
                    'UPDATED_AT' => Carbon::now()
                ]);
            }
            
            echo 'Comman Operation Successfull';
            return 1;//ok
         }catch(RequestException $e){
            return "0 " . $e->errorInfo; //some error
         }
        
    }
}

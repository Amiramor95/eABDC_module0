<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Demo;
class AutoApprovalCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:autoapproval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto approval on certain date';

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
        //sila edit function ini
        $demo = new Demo;
        $demo->value = rand(100, 200);
        $demo->save();
    }
}

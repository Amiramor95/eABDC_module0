<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\generateDocs::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('command:autoapproval')->daily()->at('22:09')->when(function () {
            return date('Y-m-d') == '2021-05-16';
        });

        // $schedule->command('command:autoapproval')->daily()->at('12:00')->when(function () use ($dateInDatabase) {
        //     return (
        //         $dateInDatabase == Carbon::today() ||
        //         $dateInDatabase == Carbon::yesterday() ||
        //         $dateInDatabase == Carbon::subDays(2)
        //     );
        // });

        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     DB::table('recent_users')->delete();
        // })->everyMinute();

        // $schedule->call('App\Http\Controllers\SmsTacController@MyAction')->everyMinute();

        //  Data Retention by every 30th June of the year
        $schedule->command('retention:data-retention')->yearlyOn(6, 30, '17:00');
        // Data Purge from Dist,Const,Third Party, TP by every 30th June of the year
        $schedule->command('purge:purge-data')->yearlyOn(6, 30, '17:00');
        // Inactive User from Dist,Const,Third Party, TP by every mid day
        $schedule->command('inactive:user-inactive')->dailyAt('13:00');
       // Autologout after 12 hours Inactivity
        $schedule->command('auto:logout')->dailyAt('23:59');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    
}

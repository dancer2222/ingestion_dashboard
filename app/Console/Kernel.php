<?php

namespace App\Console;

use App\Console\Commands\LibraryThingData;
use App\Console\Commands\LibraryThingDataXml;
use App\Console\Commands\LibraryThingDataXmlParse;
use App\Console\Commands\MakeAdmin;
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
        MakeAdmin::class,
        LibraryThingData::class,
        LibraryThingDataXmlParse::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('inspire')
                  ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

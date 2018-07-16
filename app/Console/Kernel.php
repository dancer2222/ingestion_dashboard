<?php

namespace App\Console;

use App\Console\Commands\Gmail\Reader\IngestionTracking;
use App\Console\Commands\Librarything\LibraryThingData;
use App\Console\Commands\Librarything\LibraryThingDataXmlParse;
use App\Console\Commands\Audiobooks\BindTags;
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
        IngestionTracking::class,
        BindTags::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (!app()->isLocal()) {
            // Librarything Tags
            $schedule->command('librarything_data:download')->fridays();

            // Aws notifications
            $schedule->command('gmail:read:ingestion-tracking')->twiceDaily();
        }
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

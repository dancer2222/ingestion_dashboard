<?php

namespace App\Console;

use App\Console\Commands\Books\SyncAverageRatingLT;
use App\Console\Commands\Cleaner\CleanerRemainingMetadataFiles;
use App\Console\Commands\Gmail\Reader\IngestionTracking;
use App\Console\Commands\Librarything\LibraryThingData;
use App\Console\Commands\Librarything\LibraryThingDataXmlParse;
use App\Console\Commands\Audiobooks\BindTags;
use App\Console\Commands\MakeAdmin;
use App\Console\Commands\Audiobooks\SyncAverageRating;
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
        // Core
        MakeAdmin::class,

        // Librarything
        LibraryThingData::class,
        LibraryThingDataXmlParse::class,

        // Gmail
        IngestionTracking::class,

        // Audiobooks
        BindTags::class,
        SyncAverageRating::class,

        // Books
        SyncAverageRatingLT::class,

        //Clear directory
        CleanerRemainingMetadataFiles::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if ($this->app->environment('production') || $this->app->environment('qa')) {
            // Librarything Tags
            //$schedule->command('librarything_data:download')->twiceMonthly(1);
            $schedule->command('audiobooks:bind-tags')->daily();
            $schedule->command('cleaner:metadataFiles')->daily();
        }

        if ($this->app->environment('production')) {
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

<?php

namespace App\Console\Commands\Librarything;

use App\Helpers\Ingestion\Tags\LibraryThingHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LibraryThingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarything_data:download {force?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download xml files from http://www.librarything.com/files/green';

    /**
     * @var LibraryThingHelper
     */
    private $helper;

    /**
     * Create a new command instance.
     *
     * @param $helper LibraryThingHelper
     * @return void
     */
    public function __construct(LibraryThingHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar();

        if ($this->argument('force')) {
            $feeds = $this->helper->getFeeds();
        } else {
            $feeds = $this->helper->checkForUpdates();
        }

        if (!$feeds) {
            $this->info('There is nothing to download.');
            return;
        }

        $this->info('Downloading feeds...');
        $this->line(implode(' | ', $feeds));

        $downloadedFiles = $this->helper->download($feeds, function ($dl_total_size, $dl_size_so_far, $ul_total_size, $ul_size_so_far) use ($bar) {
            $bar->start($dl_total_size);
            $bar->advance($dl_size_so_far);
        });

        $this->info('');
        $this->info('Downloaded: ' . implode(' | ', $downloadedFiles) . ' to /logs/librarything');

        $this->helper->saveLastModificationDate($downloadedFiles);
        $files = $this->helper->decompressBz2Files($downloadedFiles);

        Artisan::call('librarything_data:xml:parse', [
            '--path' => $files,
        ]);
    }
}

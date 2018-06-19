<?php

namespace App\Console\Commands;

use App\Helpers\Ingestion\Tags\LibraryThingHelper;
use Illuminate\Console\Command;

class LibraryThingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarything_data:download';

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
        $self = $this;

        $downloadedFiles = $this->helper->download($this->helper->checkForUpdates(), function ($dl_total_size, $dl_size_so_far, $ul_total_size, $ul_size_so_far) use ($self, $bar) {
            $bar->start($dl_total_size);
            $bar->advance($dl_size_so_far);
        });

        $extractedFiles = $this->helper->decompressBz2Files($downloadedFiles);
        $this->helper->saveLastModificationDate($downloadedFiles);

        $this->info('smth');
    }
}

<?php

namespace App\Console\Commands\Cleaner;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class DirectoryCleanerByMetadataFiles
 * @package App\Console\Commands\Cleaner
 */
class CleanerRemainingMetadataFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleaner:metadataFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the domain from metadata files';

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
     * @return mixed
     */
    public function handle()
    {
        $downloadPath = public_path("tmp/download");
        $file = new Filesystem();
        $file->cleanDirectory($downloadPath);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LibraryThingDataXmlSplit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarything_data:xml:split {--P|path=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Split huge xml files into parts.';

    /**
     * @var LibraryThingDataXmlSplit
     */
    private $helper;

    /**
     * Create a new command instance.
     *
     * @param LibraryThingDataXmlSplit $helper
     * @return void
     */
    public function __construct(LibraryThingDataXmlSplit $helper)
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
        if (!$this->hasOption('path')) {
            $this->info('Nothing to parse');

            return false;
        }

        $paths = $this->option('path');

        dump($paths);
    }
}

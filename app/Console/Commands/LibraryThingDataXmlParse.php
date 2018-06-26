<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Jobs\LibrarythingWorkToIsbn;
use App\Jobs\LibrarythingWorkToTags;

class LibraryThingDataXmlParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarything_data:xml:parse {--path=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decompress bzip2 files. Parse xml files and put data to the queue.';

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
        $paths = $this->option('path');

        if (!$paths) {
            return false;
        }

        foreach ($paths as $filepath) {
            if (!file_exists($filepath)) {
                $message = "File $filepath doesn't exist.";
                $this->error($message);
                logger($message);

                continue;
            }

            $method = '';

            if (str_contains($filepath, 'worktotags_current.xml')) {
                $method = 'parseWorkToTagsXml';
            } else if (str_contains($filepath, 'works_to_isbn_current.xml')) {
                $method = 'parseWorkToIsbnXml';
            }

            if (!$method) {
                continue;
            }

            try {
                $reader = new \XMLReader();
                $reader->open($filepath);

                $this->info(Carbon::now() . " Start to parse $method");

                $this->$method($reader);

                $this->info(Carbon::now() . " Finished $method");
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                logger($e->getMessage());
                continue;
            }
        }
    }

    /**
     * Parse xml work to tags
     *
     * @param \XMLReader $xmlReader
     */
    private function parseWorkToTagsXml(\XMLReader $xmlReader)
    {
        while ($xmlReader->read()) {
            if ($xmlReader->name == 'work' && ($workcode = $xmlReader->getAttribute('workcode'))) {
                try {
                    $workXml = new \SimpleXMLElement($xmlReader->readOuterXml());

                    foreach ($workXml as $tag) {
                        LibrarythingWorkToTags::dispatch([
                            'tag_id' => $tag,
                            'workcode' => $workcode,
                        ]);
                    }

                    $xmlReader->next();
                } catch (\Exception $e) {
                    $xmlReader->next();
                }
            }
        }
    }

    /**
     * Parse xml work to isbn
     *
     * @param \XMLReader $xmlReader
     */
    private function parseWorkToIsbnXml(\XMLReader $xmlReader)
    {
        while ($xmlReader->read()) {
            if ($xmlReader->name == 'work' && ($workcode = $xmlReader->getAttribute('workcode'))) {
                try {
                    $workXml = new \SimpleXMLElement(trim($xmlReader->readInnerXml()));

                    foreach ($workXml as $isbn) {
                        LibrarythingWorkToIsbn::dispatch([
                            'isbn' => (string)$isbn,
                            'workcode' => $workcode,
                        ])->onQueue('librarything-isbn');
                    }

                    $xmlReader->next();
                } catch (\Exception $e) {
                    $xmlReader->next();
                }
            }
        }
    }
}

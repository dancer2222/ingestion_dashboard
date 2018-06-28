<?php

namespace App\Console\Commands\Librarything;

use App\Models\Tag;
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
    protected $signature = 'librarything_data:xml:parse {--path=*} {--limit=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decompress bzip2 files. Parse xml files and put data to the queue.';

    /**
     * @var integer Limit of batches we put into the queue
     */
    private $limit;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('default_socket_timeout', -1);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->limit = $this->option('limit');
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

            if (str_contains($filepath, 'worktotags_current.xml')) {
                $method = 'parseWorkToTagsXml';
            } else if (str_contains($filepath, 'works_to_isbn_current.xml')) {
                $method = 'parseWorkToIsbnXml';
            } else {
                continue;
            }

            try {
                $reader = new \XMLReader();
                $reader->open($filepath, 'utf-8', LIBXML_BIGLINES | LIBXML_PARSEHUGE);

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
        $counter = 0;
        $batchesCounter = 0;
        $batches = [];

        while ($xmlReader->read()) {
            $workcode = $xmlReader->getAttribute('workcode');

            if ($xmlReader->name !== 'work' || !$workcode) {
                continue;
            }

            try {
                $xml = new \SimpleXMLElement(trim(@$xmlReader->readOuterXml()));
                $work = [
                    'workcode' => $workcode,
                    'tags' => [],
                ];

                foreach ($xml->tag as $tag) {
                    $attrs = $tag->attributes();
                    $weight = !isset($attrs['count']) ?: (string)$attrs['count'];
                    $tagName = (string)$tag;

                    if (\strlen($tagName) > 100) {
                        continue;
                    }

                    $work['tags'][] = [
                        'id' => $tagName,
                        'weight' => $weight,
                    ];
                }

                $batches[] = $work;
                $batchesCounter++;
                $counter++;

                if ($batchesCounter >= $this->limit) {
                    LibrarythingWorkToTags::dispatch($batches)->onQueue('librarything-tags');

                    $batches = [];
                    $batchesCounter = 0;
                }

                if (($counter % 50000) === 0) {
                    $this->info("$counter tags were processed.");
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                logger()->critical("LIBRARYTHING_DATA TAGS: {$e->getMessage()}");
                continue;
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
        $counter = 0;
        $batches = [];

        while ($xmlReader->read()) {
            if ($xmlReader->name !== 'work' || !($workcode = $xmlReader->getAttribute('workcode'))) {
                 continue;
            }

            try {
                $innerXml = $xmlReader->readInnerXml();
                
                if (!$innerXml) {
                    continue;
                }

                $workXml = new \SimpleXMLElement(trim($innerXml));
                $isbns = (array)$workXml->isbn;
                unset($isbns['@attributes']);

                $counter++;

                if (\count($batches) === $this->limit) {
                    LibrarythingWorkToIsbn::dispatch($batches)->onQueue('librarything-isbn');

                    $batches = [];
                }

                $batches[] = [
                    'workcode' => $workcode,
                    'isbns' => $isbns,
                ];

                if (($counter % 50000) === 0) {
                    $this->info("$counter isbns were processed.");
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                logger()->critical("LIBRARYTHING_DATA ISBNS: {$e->getMessage()}");
                continue;
            }
        }
    }
}

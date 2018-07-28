<?php

namespace App\Console\Commands\Librarything;

use Barryvdh\Debugbar\Twig\Extension\Stopwatch;
use Ingestion\LibraryThing\Xml\ParserFactory;
use App\Models\Tag;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Jobs\WorkToIsbn;
use App\Jobs\LibrarythingWorkToTags;

class LibraryThingDataXmlParse extends Command
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarything_data:xml:parse {--path=*} {--limit=1000} {cleanup? : Delete the remaining files.}';

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
        $this->info("$this->signature started at " . now()->format(self::DATE_FORMAT));

        $this->limit = $this->option('limit');
        $paths = $this->option('path');

        if (!$paths) {
            return false;
        }

        foreach ($paths as $filepath) {
            try {
                // Instantiate suitable class to parse file
                $parser = ParserFactory::make($filepath, logger());

                $startParserTime = now()->format(self::DATE_FORMAT);
                $this->info("$startParserTime - Started the parsing of the file $filepath");

                // Parse file
                $parser->parse();

                $endParserTime = now()->format(self::DATE_FORMAT);
                $this->info("$endParserTime - Finished the parsing of the file $filepath");

                // Remove remaining files
                if ($this->argument('cleanup') && unlink($filepath)) {
                    $this->info("The file $filepath was deleted.");
                }

                // Display errors
                foreach ($parser->getErrors() as $error) {
                    $this->error($error);
                    logger()->error($error);
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                logger()->critical($e->getMessage());
                continue;
            }
        }

        $this->info("$this->signature finished at " . now()->format('Y-m-d H:i:s'));
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
                        'name' => $tagName,
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
        $batchesCounter = 0;
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
                $batchesCounter++;

                if ($batchesCounter >= $this->limit) {
                    WorkToIsbn::dispatch($batches)->onQueue('librarything-isbn');

                    $batches = [];
                    $batchesCounter = 0;
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

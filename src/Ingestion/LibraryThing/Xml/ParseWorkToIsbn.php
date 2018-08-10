<?php

namespace Ingestion\LibraryThing\Xml;

use App\Jobs\Librarything\WorkToIsbn;
use Psr\Log\LoggerInterface;


class ParseWorkToIsbn extends ParserAbstract
{
    /**
     * ParseWorkToIsbn constructor.
     * @param string $filepath
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(string $filepath, LoggerInterface $logger)
    {
        parent::__construct($filepath, $logger);

        $this->setLimit(500);
        $this->setQueue('librarything-isbn');
    }

    /**
     * Parse xml file
     */
    public function handle(): void
    {
        $counter = 0;

        while ($this->reader->read()) {
            if ($this->reader->nodeType !== \XMLReader::ELEMENT || $this->reader->name !== 'work' || !($workcode = $this->reader->getAttribute('workcode'))) {
                continue;
            }

            try {
                $innerXml = $this->reader->readInnerXml();

                if (!$innerXml) {
                    continue;
                }

                $workXml = new \SimpleXMLElement(trim($innerXml));
                $isbns = (array)$workXml->isbn;
                unset($isbns['@attributes']);

                $this->addToBatch([
                    'workcode' => $workcode,
                    'isbns' => $isbns,
                ]);
                $counter++;

                if (($counter % 50000) === 0) {
                    $this->logger->info("$counter isbns were processed.");
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
                continue;
            }
        }
    }

    protected function dispatch(): void
    {
        WorkToIsbn::dispatch($this->batches)->onQueue($this->queue);
    }
}
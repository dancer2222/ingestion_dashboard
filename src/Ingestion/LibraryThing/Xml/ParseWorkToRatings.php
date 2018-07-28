<?php

namespace Ingestion\LibraryThing\Xml;

use App\Jobs\Librarything\WorkToRatings;
use Psr\Log\LoggerInterface;

class ParseWorkToRatings extends ParserAbstract
{
    /**
     * ParseWorkToRatings constructor.
     * @param string $filepath
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(string $filepath, LoggerInterface $logger)
    {
        parent::__construct($filepath, $logger);

        $this->setLimit(500);
        $this->setQueue('librarything-ratings');
    }

    /**
     * Handle xml file
     */
    protected function handle(): void
    {
        $counter = 0;

        while ($this->reader->read()) {
            if ($this->reader->nodeType !== \XMLReader::ELEMENT || $this->reader->name !== 'work' || !($workcode = $this->reader->getAttribute('workcode'))) {
                continue;
            }

            try {
                $outerXml = trim($this->reader->readOuterXml());

                if (!$outerXml) {
                    continue;
                }

                $work = [
                    'workcode' => $workcode,
                    'ratings' => [],
                ];

                $ratings = new \SimpleXMLElement($outerXml);

                foreach ($ratings->children() as $rating) {
                    $rating = (array)$rating;
                    $work['ratings'][] = [
                        'rating' => $rating['@attributes']['stars'],
                        'count' => $rating[0],
                    ];
                }

                $this->addToBatch($work);
                $counter++;

                if (!($counter % 10000)) {
                    $this->logger->info("Librarything: $counter ratings were processed.");
                }
            } catch (\RuntimeException $e) {
                $this->addError($e->getMessage());
                continue;
            }
        }
    }

    /**
     * Dispatch data to the queue
     */
    protected function dispatch(): void
    {
        WorkToRatings::dispatch($this->batches)->onQueue($this->queue);
    }
}

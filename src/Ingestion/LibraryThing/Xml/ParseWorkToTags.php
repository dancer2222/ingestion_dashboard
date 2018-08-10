<?php

namespace Ingestion\LibraryThing\Xml;

use App\Jobs\Librarything\WorkToTags;
use Psr\Log\LoggerInterface;

class ParseWorkToTags extends ParserAbstract
{
    /**
     * ParseWorkToTags constructor.
     * @param string $filepath
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(string $filepath, LoggerInterface $logger)
    {
        parent::__construct($filepath, $logger);

        $this->setLimit(500);
        $this->setQueue('librarything-tags');
    }

    /**
     * @inheritdoc
     */
    public function handle(): void
    {
        $counter = 0;

        while ($this->reader->read()) {
            if ($this->reader->nodeType !== \XMLReader::ELEMENT || $this->reader->name !== 'work' || !($workcode = $this->reader->getAttribute('workcode'))) {
                continue;
            }

            try {
                // Get tags nodes
                $xml = new \SimpleXMLElement(trim(@$this->reader->readOuterXml()));
                $work = [
                    'workcode' => $workcode,
                    'tags' => [],
                ];

                foreach ($xml->tag as $tag) {
                    $attrs = $tag->attributes();
                    $weight = !isset($attrs['count']) ?: (string)$attrs['count'];
                    $tagName = (string)$tag;

                    if (!$tagName || \strlen($tagName) > 100) {
                        continue;
                    }

                    $work['tags'][] = [
                        'name' => $tagName,
                        'weight' => $weight,
                    ];
                }

                $this->addToBatch($work);
                $counter++;

                if (($counter % 50000) === 0) {
                    $this->logger->info("$counter tags were processed.");
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
                continue;
            }
        }
    }

    /**
     * Dispatch batches to the queue
     *
     * @return void
     */
    protected function dispatch(): void
    {
        WorkToTags::dispatch($this->batches)->onQueue($this->queue);
    }
}

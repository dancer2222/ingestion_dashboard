<?php

namespace Ingestion\LibraryThing\Xml;

use App\Jobs\Librarything\WorkToIsbn;
use App\Models\ProductAudioBook;
use Illuminate\Support\Collection;
use Isbn\Isbn;
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

    /**
     * @inheritdoc
     */
    protected function dispatch(): void
    {
        WorkToIsbn::dispatch($this->batches)->onQueue($this->queue);
    }

    /**
     * @inheritdoc
     */
    protected function sanitizeData(array $data): array
    {
        $isbnHelper = new Isbn();

        // Validate all isbns at first
        $data['isbns'] = array_filter($data['isbns'], function ($isbn) use ($isbnHelper) {
            return $isbnHelper->validation->isbn10($isbn);
        });

        // Make a collection of isbn10 and related isbn13
        $isbns13 = new Collection(array_map(function ($isbn) use ($isbnHelper) {
            return [
                'isbn10' => $isbn,
                'isbn13' => $isbnHelper->translate->to13($isbn),
            ];
        }, $data['isbns']));

        // Find all products with these isbns
        $productsIsbns = ProductAudioBook::whereIn('isbn', $isbns13->pluck('isbn13'))->get()->pluck('isbn');

        // Find matches
        $matchedIsbns = $isbns13->whereIn('isbn13', $productsIsbns);

        if (!$matchedIsbns->count()) {
            return [];
        }

        // Attach only isbns which exist in our database
        $data['isbns'] = $matchedIsbns->pluck('isbn10')->toArray();

        return $data;
    }
}

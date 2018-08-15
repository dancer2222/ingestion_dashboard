<?php

namespace App\Jobs\Librarything;

use App\Models\Book;
use App\Models\BookLibrarythingData;
use App\Models\ProductAudioBook;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Isbn\Isbn;

class WorkToIsbn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Isbn
     */
    private $isbnHelper;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param Isbn $isbnHelper
     * @return void
     */
    public function handle(Isbn $isbnHelper)
    {
        $this->isbnHelper = $isbnHelper;
        $isbnWorkcode = (new Collection($this->data))->pluck('isbns', 'workcode');
        $keyed = $isbnWorkcode->mapWithKeys(function ($isbns, $workcode) {
            return array_fill_keys($isbns, $workcode);
        });

        $existingIsbns = $this->checkIfExist($keyed);

        foreach ($existingIsbns as $isbn) {
            $workcode = $keyed->get($isbn);

            if (!$workcode || !$isbn) {
                logger()->error('LIBRARYTHING_DATA ISBN LISTENER: Missing workcode or isbn.');
                $this->delete();

                continue;
            }

            try {
                $data = BookLibrarythingData::firstOrCreate(
                    ['isbn_10' => $isbn], ['workcode' => $workcode]
                );

                if (!$data) {
                    continue;
                }

                if ($data->workcode != $workcode) {
                    $data->workcode = $workcode;
                    $data->saveOrFail();
                }
            } catch (\Exception $e) {
                logger()->critical("LIBRARYTHING_DATA ISBN LISTENER: {$e->getMessage()}");
            }
        }
    }

    /**
     * Retrieve all isbns and check which from them are present in the database
     *
     * @param Collection $isbns
     * @return array
     */
    public function checkIfExist(Collection $isbns)
    {
        $isbnHelper = $this->isbnHelper;

        // Make a collection of isbn10 and related isbn13
        $isbns13 = $isbns->map(function ($workcode, $isbn) use ($isbnHelper) {
            $isbn = (string)$isbn;

            return [
                'isbn10' => $isbn,
                'isbn13' => $isbnHelper->translate->to13($isbn),
            ];
        });

        $isbns13Raw = $isbns13->pluck('isbn13')->toArray();

        // Find all products audiobooks and movies with these isbns
        $productsIsbns = ProductAudioBook::select('isbn')->whereIn('isbn', $isbns13Raw)->get()->pluck('isbn');
        $booksIsbns = Book::select('data_origin_id as isbn')->whereIn('data_origin_id', $isbns13Raw)->get()->pluck('isbn');

        // Find matches
        $matchedIsbnsAudiobooks = $isbns13->whereIn('isbn13', $productsIsbns);
        $matchedIsbnsBooks = $isbns13->whereIn('isbn13', $booksIsbns);

        if (!$matchedIsbnsAudiobooks->count() && !$matchedIsbnsBooks->count()) {
            return [];
        }

        $isbnsMergedCollection = $matchedIsbnsAudiobooks->merge($matchedIsbnsBooks);

        // Return only isbns which exist in our database
        return $isbnsMergedCollection->pluck('isbn10')->toArray();
    }
}

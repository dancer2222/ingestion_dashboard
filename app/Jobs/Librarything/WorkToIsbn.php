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
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Isbn $isbnHelper)
    {
        $this->isbnHelper = $isbnHelper;

        foreach ($this->data as $datum) {
            $workcode = $datum['workcode'] ?? '';
            $isbns = $datum['isbns'] ?? [];

            if (!$workcode || !$isbns) {
                logger()->error('LIBRARYTHING_DATA ISBN LISTENER: Missing workcode or isbns.');
                $this->delete();

                continue;
            }

            $isbns = $this->validate($isbns);

            foreach ($isbns as $isbn) {
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
    }

    public function validate(array $isbns)
    {
        $isbnHelper = $this->isbnHelper;

        // Make a collection of isbn10 and related isbn13
        $isbns13 = new Collection(array_map(function ($isbn) use ($isbnHelper) {
            return [
                'isbn10' => $isbn,
                'isbn13' => $isbnHelper->translate->to13($isbn),
            ];
        }, $isbns));

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

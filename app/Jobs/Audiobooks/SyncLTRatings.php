<?php

namespace App\Jobs\Audiobooks;

use App\Models\AudiobookAverageRating;
use App\Models\BookLibrarythingData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Ingestion\LibraryThing\Ratings\Rating;
use Isbn\Isbn;
use Illuminate\Support\Facades\DB;

class SyncLTRatings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $products;

    /**
     * @var Isbn $isbnHandler
     */
    private $isbnHandler;

    /**
     * Create a new job instance.
     *
     * @param array $products
     * @return void
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @param Isbn $isbn
     * @param Rating $ratingHelper
     * @return void
     */
    public function handle(Isbn $isbn, Rating $ratingHelper)
    {
        $jobLoggerName = "{$this->job->getQueue()} - {$this->job->getJobId()}";
        $this->isbnHandler = $isbn;
        $counter = 0;

        foreach ($this->products as $product) {
            $audiobookId = $product['audiobook'][0]['id'] ?? null;
            $productId = $product['id'];
            $productIsbn = (string)$product['isbn'];

            // Skip if there no one audiobook
            if (!$audiobookId) {
                $message = "$jobLoggerName Audiobook id not found. Product id: $productId";
                logger()->critical($message);
                $this->addError('missing_audiobook', $message, $productId);
                continue;
            }

            // Convert isbn13 to isbn10
            if (!($isbn10 = $this->convertIsbn($productIsbn))) {
                $message = "$jobLoggerName Can't convert isbn13. Product isbn: $productIsbn";
                logger()->critical($message);
                $this->addError('invalid_isbn13', $message, $productIsbn);
                continue;
            }

            // Fetch book librarything data with librarything ratings
            $bookLtData = BookLibrarythingData::select('workcode')->where('isbn_10', $isbn10)->has('ratings')->with('ratings')->first();

            // Skip iteration if we didn't get bookLtData or lt ratings
            if (!$bookLtData) {
                $message = "$jobLoggerName Lt data not found. isbn10: $isbn10";
                logger()->critical($message);
                $this->addError('no_lt_data', $message, $isbn10);
                continue;
            }

            if (!$bookLtData->ratings->count()) {
                $message = "$jobLoggerName No lt ratings. workcode: {$bookLtData->workcode}";
                logger()->info($message);
                $this->addError('no_lt_ratings', $message, $bookLtData->workcode);
                continue;
            }

            try {
                // Calculate average rating and get amount of total votes using helper
                $ltRatings = $bookLtData->ratings->pluck('count', 'rating')->toArray();
                $ratingHelper->setRatings($ltRatings);
                $averageRating = $ratingHelper->calculate();
                $totalVotes = $ratingHelper->getTotalVotes();
            } catch (\Exception $e) {
                $message = "Can't calculate average rating. Workcode: $bookLtData->workcode, Audiobook id: $audiobookId. {$e->getMessage()}. " . $bookLtData->ratings->toJson();
                logger()->critical($message);
                $this->addError('cant_calculate', $message, $bookLtData->workcode);
                continue;
            }

            try {
                // Fetch first row by audiobook id or create new row with average rating and total votes
                $audiobookAverateRatingModel = AudiobookAverageRating::firstOrCreate(
                    ['audiobook_id' => $audiobookId],
                    [
                        'rating' => $averageRating,
                        'votes_total' => $totalVotes,
                    ]
                );

                $averageRatingIsChanged = false;

                // If rating was updated
                if ($audiobookAverateRatingModel->rating != $averageRating) {
                    $audiobookAverateRatingModel->rating = $averageRating;
                    $averageRatingIsChanged = true;
                }

                // If total votes were updated
                if ($audiobookAverateRatingModel->votes_total !== $totalVotes) {
                    $audiobookAverateRatingModel->votes_total = $totalVotes;
                    $averageRatingIsChanged = true;
                }

                // Save model if some of properties was changed
                if ($averageRatingIsChanged) {
                    $audiobookAverateRatingModel->save();
                }
            } catch (\Exception $e) {
                logger()->critical($e->getMessage());
                $this->addError('others', $e->getMessage(), 'stub');
                continue;
            }

            // If we've reached this point with no errors we increase the counter
            $counter++;
            if (($counter % 50) === 0) {
                logger()->info("$jobLoggerName Processed - $counter");
            }
        }
    }

    /**
     * Fill errors table and write log if local env
     *
     * @param string $reason
     * @param string $data
     * @param $keydata
     */
    private function addError(string $reason, string $data, $keydata)
    {
        if (app()->environment('local')) {
            if (!\in_array($reason, ['others', 'no_lt_data', 'no_lt_ratings', 'cant_calculate', 'missing_audiobook', 'invalid_isbn13'])) {
                logger()->critical("Wrong reason: $reason");
                return;
            }

            try {
                // Make sure that the table exists, if not, create it
                DB::connection('mysql_dev')->table('librarything_errors')->insert([
                    [
                        'reason' => $reason,
                        'data' => $data,
                        'keydata' => $keydata,
                    ],
                ]);
            } catch (\Exception $e) {
                logger()->critical("Can't save error in database. Error: {$e->getMessage()}");
            }
        }
    }

    /**
     * Convert isbn13 to isbn10
     *
     * @param string $isbn13
     * @return bool|string
     */
    private function convertIsbn(string $isbn13)
    {
        try {
            if ($this->isbnHandler->validation->isbn13($isbn13) && ($isbn10 = $this->isbnHandler->translate->to10($isbn13))) {
                return $isbn10;
            }
        } catch (\Exception $e) {
            logger()->critical("Wrong isbn13: $isbn13. Error message: {$e->getMessage()}");
            return false;
        }
    }
}

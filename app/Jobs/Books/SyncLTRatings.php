<?php

namespace App\Jobs\Books;

use App\Models\BookAverageRatingLT;
use App\Models\BookLibrarythingData;
use Illuminate\Support\Collection;
use Ingestion\LibraryThing\Ratings\Rating;
use Isbn\Isbn;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;

class SyncLTRatings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array $books
     */
    private $books;

    /**
     * @var Isbn $isbnHandler
     */
    private $isbnHandler;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $books)
    {
        $this->books = $books;
    }

    /**
     * Execute the job.
     *
     * @param Isbn $isbn
     * @param Rating $ratingHelper
     * @return void
     */
    public function handle(Isbn $isbnHandler, Rating $ratingHelper)
    {
        $jobLoggerName = "{$this->job->getQueue()} - {$this->job->getJobId()}";
        $this->isbnHandler = $isbnHandler;

        // Filter books by isbn and add isbn10 to each of them
        $booksWithValidIsbn = (new Collection($this->books))->mapWithKeys(function ($item, $key) use ($isbnHandler) {
            $isbn13 = "{$item['data_origin_id']}";

            if ($isbnHandler->validation->isbn13($isbn13) && ($isbn10 = $isbnHandler->translate->to10($isbn13))) {
                $item['isbn10'] = $isbn10;

                return [$key => $item];
            }

            return [];
        });

        // Fetch all existed workcodes with ratings
        $booksLtData = BookLibrarythingData::has('ratings')
            ->with('ratings')
            ->whereIn('isbn_10', $booksWithValidIsbn->pluck('isbn10')->toArray())
            ->get();

        if (!$booksLtData) {
            $message = "$jobLoggerName No LT ratings found. Isbns 10: {$booksWithValidIsbn->pluck('isbn10')->toJson()}";
            logger()->info($message);

            return;
        }

        // Calculate the rating of each item and save it in the appropriate table
        foreach ($booksLtData as $bookLt) {
            try {
                $ltRatings = $bookLt->ratings->pluck('count', 'rating')->toArray();

                $ratingHelper->setRatings($ltRatings);
                $averageRating = $ratingHelper->calculate();
                $totalVotes = $ratingHelper->getTotalVotes();

                $bookAverageRatingModel = BookAverageRatingLT::firstOrCreate(
                    ['book_id' => $booksWithValidIsbn->where('isbn10', $bookLt->isbn_10)->pluck('seq_id')->first()],
                    [
                        'rating' => $averageRating,
                        'votes_total' => $totalVotes,
                    ]
                );

                if ($bookAverageRatingModel->rating != $averageRating || $bookAverageRatingModel->votes_total != $totalVotes) {
                    $bookAverageRatingModel->rating = $averageRating;
                    $bookAverageRatingModel->votes_total = $totalVotes;
                    $bookAverageRatingModel->save();
                }
            } catch (\Exception $e) {
                logger()->critical($e->getMessage());
            }
        }
    }
}

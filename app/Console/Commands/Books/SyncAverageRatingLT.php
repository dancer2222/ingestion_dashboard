<?php

namespace App\Console\Commands\Books;

use App\Models\Book;
use App\Jobs\Books\SyncLTRatings;
use Illuminate\Console\Command;

class SyncAverageRatingLT extends Command
{
    const QUEUE_NAME = 'books-ratings-lt';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:lt-rating-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync books ratings we got from Librarything';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $self = $this;
        $booksCounter = 0;
        $dateStart = new \DateTime();
        $this->output->writeln('Started at: ' . $dateStart->format('H:i:s'));

        Book::select('seq_id', 'data_origin_id')
            ->whereNotNull('data_origin_id')
            ->chunk(5000, function ($books) use (&$booksCounter, $self) {
                $booksCounter += $books->count();

                SyncLTRatings::dispatch($books->toArray())->onQueue($self::QUEUE_NAME);
            });

        $dateEnd = new \DateTime();
        $diff = $dateStart->diff($dateEnd);
        $this->output->writeln("Processed Books: $booksCounter");
        $this->output->writeln('Spend time: ' . $diff->format('%H:%I:%S'));
        $this->output->writeln('Finished at: ' . $dateEnd->format('H:i:s'));
    }
}

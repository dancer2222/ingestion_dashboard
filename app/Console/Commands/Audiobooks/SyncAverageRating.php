<?php

namespace App\Console\Commands\Audiobooks;

use App\Jobs\Audiobooks\SyncLTRatings;
use App\Models\ProductAudioBook;
use Illuminate\Console\Command;

class SyncAverageRating extends Command
{
    const QUEUE_NAME = 'audiobooks-ratings-lt';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audiobooks:lt-rating-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync audiobooks average rating depending on rating provider';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $self = $this;
        $productsCounter = 0;
        $dateStart = new \DateTime();
        $this->output->writeln('Started at: ' . $dateStart->format('H:i:s'));

        ProductAudioBook::select('id', 'isbn')
            ->whereNotNull('isbn')
            ->has('audiobook')
            ->with('audiobook:id')->chunk(5000, function ($products) use (&$productsCounter, $self) {
                $productsCounter += $products->count();

                SyncLTRatings::dispatch($products->toArray())->onQueue($self::QUEUE_NAME);
        });


        $dateEnd = new \DateTime();
        $diff = $dateStart->diff($dateEnd);
        $this->output->writeln("Processed Products: $productsCounter");
        $this->output->writeln('Spend time: ' . $diff->format('%H:%I:%S'));
        $this->output->writeln('Finished at: ' . $dateEnd->format('H:i:s'));
    }
}

<?php

namespace App\Console\Commands\Librarything;

use App\Models\ProductAudioBook;
use Illuminate\Console\Command;
use App\Models\MediaType;
use Illuminate\Database\Eloquent\Collection;

class LibraryThingRating extends Command
{
    /**
     * @var string
     */
    const DATE_FORMAT = 'Y-m-d H:i:s';
    const MEDIATYPE_TITLE = 'audiobooks';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audiobooks:update:librarything-rating {--batch=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It gets recently modified batches and ';

    /**
     * @var Collection  of batches
     */
    private $batches;


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->loadBatches();

        //foreach (ProductAudioBook::where('status', 'active')->cursore() as $product) {
            //$audiobook = $product->audiobook()->where('');
        //}
    }

    private function loadRecentlyModifiedBatches(MediaType $mediaType)
    {
        $dateFrom = now()->modify('-48 hour')->format(self::DATE_FORMAT);
        $dateTo = now()->modify('-24 hour')->format(self::DATE_FORMAT);

        $this->batches = $mediaType->batches()
            ->select('id')
            ->whereBetween('import_date', [$dateFrom, $dateTo])
            ->get();
    }
}

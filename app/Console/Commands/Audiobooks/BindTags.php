<?php

namespace App\Console\Commands\Audiobooks;

use App\Jobs\Audiobooks\BindLibrarythingTags;
use App\Models\AudiobookTag;
use App\Models\MediaType;
use App\Models\AudiobookTagBlacklist;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class BindTags extends Command
{
    const MEDIATYPE_TITLE = 'audiobooks';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audiobooks:bind-tags {--batch=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It binds tags to audiobook.';

    /**
     * @var string
     */
    private $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var int
     */
    private $limit = 5000;

    /**
     * @var Collection  of batches
     */
    private $batches;

    /**
     * @var array [batchId][Collection of ProductAudiobooks]
     */
    private $productAudiobooks = [];

    /**
     * @var int counter
     */
    private $processedProducts = 0;

    /**
     * Handle the command
     */
    public function handle()
    {
        // Start info
        $timeStart = now();
        $startMessage = "Command: [$this->signature] started at {$timeStart->format($this->dateFormat)}";
        $this->info($startMessage);

        // Main logic
        $this->updateBoundTags();
        $this->loadBatches();

        if (!$this->batches || !$this->batches instanceof Collection || !$this->batches->count()) {
            $this->info('There are no suitable batches in the database to process.');
        } else {
            $this->info(\count($this->batches) . ' batches are ready to process.');

            $this->loadProductAudioBooks();
            $this->processProducts();
        }

        // Conclusion
        $timeEnd = now();
        $spentTime = $timeStart->diff($timeEnd);
        $this->info("Command: [$this->signature] finished at {$timeEnd->format($this->dateFormat)}.");
        $this->info("Spent time: $spentTime->h:$spentTime->i:$spentTime->s");
        $this->info("Processed products: $this->processedProducts");
    }

    /**
     * Fetch all tags from the blacklist,
     * delete all entities that were bound to any of these tags
     */
    private function updateBoundTags()
    {
        $this->info('Syncing bound tags with the blacklist...');
        $counter = 0;

        AudiobookTagBlacklist::chunk($this->limit, function ($tags) use (&$counter) {
            $counter += \count($tags);

            foreach ($tags as $tag) {
                AudiobookTag::where('tag_id', $tag->tag_id)->delete();
            }
        });

        $this->info("Tags have been synchronized. ($counter)");
    }

    /**
     * Determine and invoke the method to load batches
     */
    private function loadBatches()
    {
        $userBatches = $this->option('batch');
        $mediaType = MediaType::whereTitle(self::MEDIATYPE_TITLE)->first();

        if ($userBatches) {
            $this->loadUserBatches($mediaType, $userBatches);

            return;
        }

        $this->loadRecentlyModifiedBatches($mediaType);
    }

    /**
     * Fetches the batches using the passed batch id (or ids)
     *
     * @param MediaType $mediaType
     * @param array $ids
     */
    private function loadUserBatches(MediaType $mediaType, array $ids)
    {
        $this->batches = $mediaType->batches()->whereIn('id', $ids)->select('id')->get();
    }

    /**
     * Fetches the batches from database which were modified the day before yesterday
     *
     * @param MediaType $mediaType
     */
    private function loadRecentlyModifiedBatches(MediaType $mediaType)
    {
        $dateFrom = now()->modify('-48 hour')->format($this->dateFormat);
        $dateTo = now()->modify('-24 hour')->format($this->dateFormat);

        $this->batches = $mediaType->batches()
            ->select('id')
            ->whereBetween('import_date', [$dateFrom, $dateTo])
            ->get();
    }

    /**
     * Fetches product audiobooks from database
     */
    private function loadProductAudioBooks()
    {
        $self = $this;
        $bar = $this->output->createProgressBar();

        foreach ($this->batches as $index => $batch) {
            $this->info('Fetching products audiobooks from database...');

            $batchId = $batch->id;
            $self->productAudiobooks[$batchId] = new Collection;

            $productsModel = $batch->productAudiobooks();
            $productsModel->where('status', 'active')
                ->where('isbn', '<>', 0)
                ->where('batch_id', $batchId);

            $productsCount = $productsModel->count();

            $bar->setMaxSteps($productsCount);

            $this->info("Batch id: $batchId. Audiobooks: $productsCount");

            $productsModel->chunk($this->limit, function ($products) use ($batchId, &$self, $bar) {
                $bar->advance($this->limit);

                $this->processedProducts += $products->count();
                $self->productAudiobooks[$batchId] = $self->productAudiobooks[$batchId]->merge($products);
            });
        }
    }

    /**
     * Process product audiobooks
     */
    private function processProducts()
    {
        foreach ($this->productAudiobooks as $batchId => $productsAudiobooks) {
            $productsCount = $productsAudiobooks->count();
            $this->info("Process audiobooks... ($productsCount). Batch id: $batchId");
            $bar = $this->output->createProgressBar($productsCount);

            foreach ($productsAudiobooks as $productAudiobook) {
                try {
                    $bar->advance();

                    BindLibrarythingTags::dispatch($productAudiobook)->onQueue('librarything-audiobooks-tags');
                } catch (\Exception $e) {
                    $error = "An error occurred while processing the product: {$e->getMessage()}.";
                    $error .= " Product id: $productAudiobook->id; Batch id: $batchId";

                    $this->error($error);
                    logger()->error($error);
                }
            }
        }
    }
}

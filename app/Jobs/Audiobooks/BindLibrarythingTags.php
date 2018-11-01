<?php

namespace App\Jobs\Audiobooks;

use App\Models\Audiobook;
use App\Models\ProductAudioBook;
use App\Models\BookLibrarythingData;
use Illuminate\Database\Eloquent\Collection;
use Isbn\Isbn;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BindLibrarythingTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MAX_BOUND_TAGS = 30;

    /**
     * @var ProductAudioBook
     */
    private $product;

    /**
     * @var Isbn
     */
    private $isbn;

    /**
     * Create a new job instance.
     *
     * @param ProductAudioBook $productAudioBook
     * @return void
     */
    public function __construct(ProductAudioBook $productAudioBook)
    {
        $this->product = $productAudioBook;
    }

    /**
     * @param Isbn $isbn
     */
    public function handle(Isbn $isbn)
    {
        $this->isbn = $isbn;
        try {
            $this->processProduct($this->product);
        } catch (\Exception $e) {
            $error = "An error occurred while processing the product: {$e->getMessage()}.";
            $error .= " Product id: {$this->product->id};";

            $this->critical($error);
        }
    }

    /**
     * Validate and convert isbn from isbn13 to isbn10.
     * Gets workcode by isbn10 and related tags.
     *
     * @param ProductAudioBook $product
     * @throws \Isbn\Exception
     */
    private function processProduct(ProductAudioBook $product)
    {
        if (!$this->isbn->validation->isbn13((string)$product->isbn)) {
            $error = "Wrong product isbn13 - $product->isbn (id: $product->id)";
            $this->critical($error);

            return;
        }

        $isbn10 = $this->isbn->translate->to10((string)$product->isbn);
        $bookLibrarythingData = BookLibrarythingData::select('workcode')->whereIsbn_10($isbn10)->first();

        if (!$bookLibrarythingData) {
            return;
        }

        $tags = $bookLibrarythingData->tags()->orderBy('weight', 'desc')->limit(self::MAX_BOUND_TAGS)->get();

        if (!$tags) {
            return;
        }

        $audiobook = $product->audiobook;

        if ($audiobook->count() !== 1) {
            return;
        }

        $this->bindTagsToAudiobook($audiobook->first(), $tags);
    }

    /**
     * Bind tags to audiobook.
     *
     * @param Audiobook $audiobook
     * @param Collection $tags
     */
    private function bindTagsToAudiobook(Audiobook $audiobook, Collection $tags)
    {
        $tagIds = $tags->pluck('tag_id');
        $weight = $tags->pluck('weight');

        if (!$tagIds && !$weight) {
            return;
        }

        // Check if the audiobook already has the same tags we're going to bind
        $duplicateTagsCount = $audiobook->tags()->whereIn('tag_id', $tagIds)->count();

        // If it's the same amount as MAX_BOUND_TAGS we have to do nothing
        if ($duplicateTagsCount === self::MAX_BOUND_TAGS) {
            return;
        }

        $boundTagsCount = $audiobook->tags()->count();

        // Just sync the tags if the audiobook doesn't have any bound tags
        // or amount of bound tags is more than MAX_BOUND_TAGS
        if (!$boundTagsCount || $boundTagsCount > self::MAX_BOUND_TAGS) {
            // It'll detach all bound tags and attach new ones
            $audiobook->tags()->sync([$tagIds[0] => ['weight' => $weight[0]]]);

            return;
        }

        // Determines how many tags we can attach to the audiobook
        $toTake = self::MAX_BOUND_TAGS - $boundTagsCount + $duplicateTagsCount;

        $audiobook->tags()->syncWithoutDetaching([$tagIds[0]->take($toTake) => ['weight' => $weight[0]->take($toTake)]]);
    }

    /**
     * Display an error message in cli and write to log
     *
     * @param string $message
     * @param bool $send
     */
    private function critical(string $message, bool $send = false)
    {
        logger()->error($message);

        if ($send) {
            // TODO: send mail with an error
        }
    }
}

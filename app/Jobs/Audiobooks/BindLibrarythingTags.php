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

        // Convert product isbn (isbn-13) to isbn-10, then find workcode by converted isbn-10
        $isbn10 = $this->isbn->translate->to10((string)$product->isbn);
        $bookLibrarythingData = BookLibrarythingData::select('workcode')->whereIsbn_10($isbn10)->first();

        // Skip if we have no workcode
        if (!$bookLibrarythingData) {
            return;
        }

        $tags = $bookLibrarythingData->tags()->orderBy('weight', 'desc')->limit(self::MAX_BOUND_TAGS)->get();

        // Skip if have no tags by current workcode
        if (!$tags) {
            return;
        }

        $audiobook = $product->audiobook;

        // Skip if we have no audiobooks by passed product audiobook
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
        $tagIds = [];
        $tagsWithWeight = [];

        foreach ($tags as $tag) {
            // Collect tag ids and tag ids with weight to store in database
            $tagId = $tag->tag_id;
            $tagIds[] = $tagId;
            $tagsWithWeight[$tagId] = ['weight' => $tag->weight];
        }

        if (!$tagIds && !$tagsWithWeight) {
            return;
        }

        // Check if the audiobook already has the same tags we're going to bind
        $boundAudiobookTags = $audiobook->tags()->select('tag_id')->get();
        $duplicateTags = array_intersect($boundAudiobookTags->pluck('tag_id')->toArray(), $tagIds);
        $duplicateTagsCount = \count($duplicateTags);

        // If it's the same amount as MAX_BOUND_TAGS we have to do nothing
        if ($duplicateTagsCount === self::MAX_BOUND_TAGS) {
            return;
        }

        if ($duplicateTags) {
            $tagIds = array_diff($tagIds, $duplicateTags);
        }

        $boundTagsCount = $boundAudiobookTags->count();

        // Just sync the tags if the audiobook doesn't have any bound tags
        // or amount of bound tags is more than self::MAX_BOUND_TAGS
        if (!$boundTagsCount || $boundTagsCount > self::MAX_BOUND_TAGS) {
            // It'll detach all bound tags and attach new ones
            $audiobook->tags()->sync($tagsWithWeight);

            return;
        }

        // Remove already bound tags
        $tagsWithoutDuplicates = collect($tagsWithWeight)->filter(function ($value, $key) use ($duplicateTags) {
            return \in_array($key, $duplicateTags, true) === false;
        });

        $audiobook->tags()->syncWithoutDetaching($tagsWithoutDuplicates);
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

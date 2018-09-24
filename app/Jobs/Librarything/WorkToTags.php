<?php

namespace App\Jobs\Librarything;

use App\Models\BookLibrarythingData;
use App\Models\Tag;
use App\Models\LibrarythingTag;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class WorkToTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

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
     * @return void
     */
    public function handle()
    {
        $data = $this->sift();

        foreach ($data as $datum) {
            $workcode = $datum['workcode'];

            // Make collection from tags array
            $tags = collect($datum['tags'] ?: []);

            // Rewrite the tag name in lowercase
            $tags = $tags->map(function ($item) {
                $item['name'] = strtolower($item['name']);
                return $item;
            });

            // Fetch all existed tags from the database
            $tagsPresentInDb = Tag::whereIn('name', $tags->pluck('name'))->get();

            // Rewrite the model tag name in lowercase
            $tagsPresentInDb = $tagsPresentInDb->map(function ($item) {
                $item->name = strtolower($item->name);
                return $item;
            });

            // Find the difference if we have nonexistent tags
            $tagsToStore = $tags->whereIn('name', $tags->pluck('name')->diff($tagsPresentInDb->pluck('name'))->toArray());

            if ($tagsPresentInDb->count() !== $tags->count()) {
                foreach ($tagsToStore as $tagToSave) {
                    try {
                        $result = Tag::create(['name' => $tagToSave['name']]);

                        $tagsPresentInDb->push($result);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            $ltTags = LibrarythingTag::where('workcode', $workcode)->whereIn('tag_id', $tagsPresentInDb->pluck('id')->toArray())->get();

            foreach ($ltTags as $ltTag) {
                   try {
                       $tagName = collect($tagsPresentInDb->where('id', $ltTag->tag_id)->first())->get('name');
                       $weight = collect($tags->where('name', $tagName)->first())->get('weight');

                       if ($weight !== null && $ltTag->weight != $weight) {
                           LibrarythingTag::where('tag_id', $ltTag->tag_id)
                               ->where('workcode', $workcode)
                               ->update(['weight' => $weight]);
                       }
                   } catch (\Exception $e) {
                       logger()->critical("LIBRARYTHING_DATA LISTENER TAGS {$e->getMessage()}");
                       continue;
                   }
            }

            $ltTagsToStore = $tagsPresentInDb->whereNotIn('id', $ltTags->pluck('tag_id')->toArray());

            foreach ($ltTagsToStore as $ltTag) {
                try {
                    $weight = collect($tags->where('name', $ltTag->name)->first())->get('weight');

                    if (!$ltTag->name || !$weight) {
                        continue;
                    }

                    LibrarythingTag::create([
                        'workcode' => $workcode,
                        'tag_id' => $ltTag->id,
                        'weight' => $weight,
                    ]);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
    }

    /**
     * Sift data
     *
     * @return array
     */
    public function sift(): array
    {
        $data = new Collection($this->data);
        $dataLt = BookLibrarythingData::select('workcode')
            ->whereIn('workcode', $data->pluck('workcode')->toArray())
            ->distinct()
            ->get(['workcode']);

        return $dataLt->count() ? $data->whereIn('workcode', $dataLt->pluck('workcode'))->toArray() : [];
    }
}

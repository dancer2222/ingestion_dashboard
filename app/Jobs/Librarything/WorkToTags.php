<?php

namespace App\Jobs\Librarything;

use App\Models\Tag;
use App\Models\LibrarythingTag;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        foreach ($this->data as $datum) {
            $workcode = $datum['workcode'];
            $tags = $datum['tags'] ?: [];

            foreach ($tags as $tag) {
                try {
                    $name = $tag['name'];
                    $weight = $tag['weight'];

                    if (!$name) {
                        continue;
                    }

                    $tagDb = Tag::firstOrCreate(['name' => $name]);

                    if (!$tagDb) {
                        continue;
                    }

                    $librarythingTagWhere = ['workcode' => $workcode, 'tag_id' => $tagDb->id];
                    $librarythingTag = LibrarythingTag::select('weight')->where($librarythingTagWhere)->first();

                    if ($librarythingTag && $librarythingTag->weight !== $weight) {
                        LibrarythingTag::where($librarythingTagWhere)->update(['weight' => $weight]);
                    } elseif (!$librarythingTag) {
                        $librarythingTagWhere['weight'] = $weight;

                        LibrarythingTag::create($librarythingTagWhere);
                    }
                } catch (\Exception $e) {
                    logger()->critical("LIBRARYTHING_DATA LISTENER TAGS {$e->getMessage()}");
                    continue;
                }
            }
        }
    }
}

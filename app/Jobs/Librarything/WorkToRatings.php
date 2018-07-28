<?php

namespace App\Jobs\Librarything;

use App\Models\LibrarythingRatings;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WorkToRatings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;

    /**
     * WorkToRatings constructor.
     * @param array $data
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
            $workcode = $datum['workcode'] ?? null;
            $ratings = $datum['ratings'] ?? null;

            foreach ($ratings as $rating) {
                try {
                    $ratingDb = LibrarythingRatings::firstOrCreate(
                        ['workcode' => $workcode, 'rating' => $rating['rating']],
                        ['count' => $rating['count']]
                    );

                    if (!$ratingDb) {
                        continue;
                    }

                    if ($ratingDb->count != $rating['count']) {
                        $ratingDb->count = $rating['count'];
                    }
                } catch (\RuntimeException $e) {
                    logger()->critical("Librarything ratings: {$e->getMessage()}");
                    continue;
                }
            }
        }
    }
}

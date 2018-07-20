<?php

namespace App\Jobs;

use App\Models\BookLibrarythingData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LibrarythingWorkToIsbn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
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
            $workcode = $datum['workcode'] ?? '';
            $isbns = $datum['isbns'] ?? [];

            if (!$workcode || !$isbns) {
                logger()->error('LIBRARYTHING_DATA ISBN LISTENER: Missing workcode or isbns.');
                $this->delete();

                continue;
            }

            foreach ($isbns as $isbn) {
                try {
                    $data = BookLibrarythingData::firstOrCreate(
                        ['isbn_10' => $isbn], ['workcode' => $workcode]
                    );

                    if (!$data) {
                        continue;
                    }

                    if ($data->workcode != $workcode) {
                        $data->workcode = $workcode;
                        $data->saveOrFail();
                    }
                } catch (\Exception $e) {
                    logger()->critical("LIBRARYTHING_DATA ISBN LISTENER: {$e->getMessage()}");
                }
            }
        }
    }
}

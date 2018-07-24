<?php

namespace App\Console\Commands\Audiobooks;

use App\Models\ProductAudioBook;
use Illuminate\Console\Command;

class LibrarythingRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audiobooks:update:librarything-rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (ProductAudioBook::where('status', 'active')->cursore() as $product) {
            $audiobook = $product->audiobook()->where('');
        }
    }
}

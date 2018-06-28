<?php

namespace App\Console\Commands\Gmail\Reader;

use Ingestion\Api\Gmail\Gmail;
use Illuminate\Console\Command;

class IngestionTracking extends Command
{
    const USER_ID = 'me';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read:ingestion-tracking {--subject=ingestiontracking@playster.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Gmail
     */
    private $gmail;

    /**
     * @var array Default params for Gmail
     */
    private $params = [
        'from:no-reply@sns.amazonaws.com',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Gmail $gmail)
    {
        $this->gmail = $gmail;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->gmail->setSubject($this->input->getOption('subject'));
        $messages = $this->gmail->getMessages(self::USER_ID, $this->params);
        dd($messages);
    }
}

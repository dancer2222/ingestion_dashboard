<?php

namespace App\Console\Commands\Gmail\Reader;

use App\Models\AwsNotication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Ingestion\Api\Gmail\Gmail;
use Illuminate\Console\Command;

class IngestionTracking extends Command
{
    const USER_ID = 'me';
    const SUBJECT = 'ingestiontracking@playster.com';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read:ingestion-tracking';

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
        'q' => 'from:no-reply@sns.amazonaws.com is:unread',
        'maxResults' => '500',
    ];

    /**
     * @var array Ids of got messages
     */
    private $messagesIds = [];

    /**
     * @var array Array of messages with keys 'body', 'date', 'from'.
     */
    private $messages = [];

    /**
     * Create a new command instance.
     *
     * @param Gmail $gmail
     * @return void
     */
    public function __construct(Gmail $gmail)
    {
        $this->gmail = $gmail;
        $this->gmail->setSubject(self::SUBJECT);

        $date = Carbon::now();
        $datePrevDay = $date->addDay(-1)->format('Y/m/d');

        // Modify query
        $this->params['q'] .= " newer:$datePrevDay";

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->collectMessagesIds();

        if (!$this->messagesIds) {
            $message = 'There are not any messages for today.';
            $this->info($message);
            logger()->info($message);

            return;
        }

        $this->collectMessages();
        $this->storeMessages();
        $this->deleteMessages();

        $message = 'Aws notifications finished. Were inserted ' . \count($this->messages) . ' notifications.';
        $this->info($message);
        logger()->info($message);

        exit(0);
    }

    /**
     * Delete messages from mailbox
     */
    private function deleteMessages()
    {
        foreach ($this->messages as $messageId => $message) {
            $this->gmail->deleteMessage(self::USER_ID, $messageId);
        }
    }

    /**
     * @param string $body
     * @return mixed|null
     */
    private function parseBody(string $body)
    {
        $pregResult = preg_match('/{"Records":.*}}}]}/m', $body, $matches);

        if ($pregResult && preg_last_error() === PREG_NO_ERROR && (($std = json_decode($matches[0])) && json_last_error() === JSON_ERROR_NONE)) {
            return $std;
        }

        return null;
    }

    /**
     * Store messages in database.
     */
    private function storeMessages()
    {
        foreach ($this->messages as $messageId => $message) {
            try {
                if (!isset($message->Records) || !$message->Records || !\is_array($message->Records)) {
                    throw new \Exception;
                }

                foreach ($message->Records as $record) {
                    $data['event_time'] = $record->eventTime ?? null;
                    $data['event_name'] = $record->eventName ?? null;
                    $data['bucket'] = $record->s3->bucket->name ?? null;
                    $data['key'] = $record->s3->object->key ?? null;
                    $data['size'] = $record->s3->object->size ?? null;

                    $validator = Validator::make($data, [
                        'event_time' => 'present',
                        'event_name' => 'present',
                        'bucket' => 'present|max:50',
                        'key' => 'present',
                        'size' => 'present|max:30',
                    ]);

                    if ($validator->fails()) {
                        throw new \Exception;
                    }

                    // Modify date after validation
                    $data['event_time'] = Carbon::parse($data['event_time'])->format('Y-m-d');

                    AwsNotication::create($data);
                }
            } catch (\Exception $e) {
                logger()->critical($e->getMessage());
                unset($this->messages[$messageId]);

                continue;
            }
        }
    }

    /**
     * Collect messages using ids that we get before.
     */
    private function collectMessages()
    {
        $countIds = \count($this->messagesIds);
        $message = "Receiving messages ($countIds)";

        $this->info($message);
        logger()->info($message);

        $bar = $this->output->createProgressBar($countIds);

        foreach ($this->messagesIds as $messageId) {
            try {
                $message = $this->gmail->getMessage(self::USER_ID, $messageId);

                $this->messages[$messageId] = $this->parseBody($message->body ?: '');

                $bar->advance();
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                logger()->critical($e->getMessage());

                continue;
            }
        }
    }

    /**
     * Gets messages ids for last two days
     *
     * @param array $params
     */
    private function collectMessagesIds(array $params = [])
    {
        $params = array_merge($this->params, $params);
        $response = $this->gmail->getMessages(self::USER_ID, $params);

        if (!$response) {
            return;
        }

        $messages = $response->getMessages();

        foreach ($messages as $message) {
            $this->messagesIds[] = $message->getId();
        }

        $nextPageToken = $response->getNextPageToken();

        if ($nextPageToken && $messages) {
            $this->collectMessagesIds(['pageToken' => $nextPageToken]);
        }
    }
}

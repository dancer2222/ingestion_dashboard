<?php

namespace Ingestion\Parse;

use Illuminate\Support\Facades\DB;
use Bschmitt\Amqp\Facades\Amqp;
use App\Models\AwsNotication;
use Carbon\Carbon;
use Exception;

/**
 * Class AwsNotifications
 * @package Ingestion\Parse
 */
class AwsNotifications
{
    /**
     * Read messages from queue 'adjuster'
     */
    public function read()
    {
        Amqp::consume('adjuster', function($message, $resolver) {
            $messages = [];

            if (isset($message->body) && $message->body) {
                $body = json_decode($message->body);

                if ($body && is_array($body)) {
                    $messages = $this->parse($body);
                }
            }

            if ($messages) {
                $this->store($messages);

                $resolver->acknowledge($message);
            } else {
                $resolver->reject($message, true);
            }

            $resolver->stopWhenProcessed();
        });
    }

    /**
     * Fetch aws objects from message using regex
     *
     * @param array $messages
     * @return array
     */
    public function parse(array $messages): array
    {
        $records = [];

        try {
            foreach ($messages as $key => $message) {
                preg_match("/({.*{?{?{?\[?}?}?}?]?})/", $message->body, $matches);

                if (preg_last_error() === PREG_NO_ERROR && count($matches) > 0) {
                    $awsObj = json_decode(array_reverse($matches)[0]);

                    if (json_last_error() === JSON_ERROR_NONE && $awsObj && isset($awsObj->Records) && count($awsObj->Records)) {
                        foreach ($awsObj->Records as $record) {
                            $records[] = [
                                'eventTime' => Carbon::parse($record->eventTime),
                                'eventName' => $record->eventName,
                                'bucket'    => $record->s3->bucket->name,
                                'key'       => $record->s3->object->key,
                                'size'      => $record->s3->object->size . ' bytes'
                            ];
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            logger()->critical("An error occurred while parsing aws messages from queue 'adjuster'" . $exception->getMessage());

            return [];
        }

        return $records;
    }

    /**
     * Store messages to database
     *
     * @param array $records
     */
    public function store(array $records)
    {
        foreach ($records as $record) {
            DB::transaction(function () use ($record) {
                AwsNotication::create($record);
            });
        }
    }
}

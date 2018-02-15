<?php

namespace Ingestion\Parse;

use Ingestion\Tools\RabbitMQ;

/**
 * Class AwsNotifications
 * @package Ingestion\Parse
 */
class AwsNotifications
{
    /**
     * AwsNotificationsController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return $this|string
     */
    public function read()
    {
        try {
            $rabbit = new RabbitMQ(config('main.rabbitMq'));
            $message = $rabbit->readMessage();
            $rabbit->closeConnection();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $message;

    }

    /**
     * @param null $message
     * @return array
     */
    public function parse($message = null)
    {
        $message = file_get_contents('download/scratch.json');
        $messages = json_decode($message);
        $product = [];
        foreach ($messages as &$item) {
            if ($item->body) {
                $position = strpos($item->body, '}}}]}');
                $item->body = json_decode(substr($item->body, 0, $position) . '}}}]}');

                foreach ($item->body as $message) {
                    foreach ($message as $value) {
                        $value->info = [
                            'date'      => $item->date,
                            'eventTime' => $value->eventTime,
                            'eventName' => $value->eventName,
                            'bucket'    => $value->s3->bucket->name,
                            'key'       => $value->s3->object->key,
                            'size'      => $value->s3->object->size . ' bytes'
                        ];
                        $product [] = $value->info;
                    }
                }
            }
        }

        return $product;
    }
}
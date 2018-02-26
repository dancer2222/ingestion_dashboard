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
     * @return array|\Exception|string
     */
    public function read()
    {
        try {
            $rabbit = new RabbitMQ(config('services.rabbitAdjuster'));
            $rabbit->createChanel();
            $message = $rabbit->readMessage();
            $rabbit->closeConnection();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $message;

    }

    /**
     * @param $messages
     * @return array
     */
    public function parse($messages): array
    {
        $allProduct = [];
        foreach ($messages as $message) {
            $messagesSecond = json_decode($message);
            $product = [];
            foreach ($messagesSecond as &$item) {
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
            $allProduct [] = $product;
        }

        return $allProduct;
    }
}
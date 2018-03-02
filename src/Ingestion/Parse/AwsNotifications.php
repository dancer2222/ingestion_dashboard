<?php

namespace Ingestion\Parse;

use App\Models\AwsNotication;
use Carbon\Carbon;
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
     * @param array $messages
     * @return array
     * @throws \Exception
     */
    public function parse(array $messages): array
    {
        $allProduct = [];

        foreach ($messages as $key => $message) {
            try {
                $messagesSecond = json_decode($message);
                $product = [];
                foreach ($messagesSecond as &$item) {
                    if ($item->body) {
                        $position = strpos($item->body, '}}}]}');
                        $item->body = json_decode(substr($item->body, 0, $position) . '}}}]}');

                        foreach ($item->body as $message) {
                            foreach ($message as $value) {
                                $value->info = [
                                    'eventTime' => Carbon::parse($value->eventTime),
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
            } catch (\Exception $exception) {
                unset($messages[$key]);

                $this->parse($messages);
            }
        }

        return $allProduct;
    }

    /**
     * @param $allProduct
     * @return bool|string
     */
    public function store($allProduct)
    {
        foreach ($allProduct as $product) {
            foreach ($product as $item) {
                AwsNotication::create($item);
            }
        }

        return false;
    }
}
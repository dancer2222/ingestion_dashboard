<?php

namespace Ingestion\Parse;

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
     * @return bool|string
     */
    public function read()
    {
        try {
            Amqp::consume('adjuster', function($message, $resolver) {

                $messages = $this->parse(json_decode($message->body));

                if ($messages && false !== $this->store($messages)) {
                    $resolver->acknowledge($message);
                } else {
                    $resolver->reject($message, true);
                }

                $resolver->stopWhenProcessed();
            });
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return false;
    }

    /**
     * @param $messages
     * @return array
     */
    public function parse($messages): array
    {
        $allProduct = [];
        $product = [];

        try {
            foreach ($messages as $key => $message) {
                foreach ($message as &$item) {
                    $position = strpos($item, '}}}]}');

                    if ($position !== false) {
                        $item = json_decode(substr($item, 0, $position) . '}}}]}');

                        foreach ($item as $value) {
                            foreach ($value as $argument) {
                                $product = [
                                    'eventTime' => Carbon::parse($argument->eventTime),
                                    'eventName' => $argument->eventName,
                                    'bucket'    => $argument->s3->bucket->name,
                                    'key'       => $argument->s3->object->key,
                                    'size'      => $argument->s3->object->size . ' bytes'
                                ];

                            }
                        }
                    } else {
                        $product = [
                            'eventTime' => Carbon::parse($message->date),
                            'eventName' => 'Fail delivery',
                            'bucket'    => $message->from,
                            'key'       => 'false',
                            'size'      => 0 . ' bytes'
                        ];
                    }

                    $allProduct [] = $product;
                }
            }
        } catch (Exception $exception) {
            return [];
        }

        return $allProduct;
    }

    /**
     * @param $allProduct
     * @return bool|string
     */
    public function store($allProduct)
    {
        try {
            foreach ($allProduct as $product) {
                AwsNotication::create($product);
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }

        return false;
    }
}
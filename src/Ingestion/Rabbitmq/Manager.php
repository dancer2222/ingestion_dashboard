<?php

namespace Ingestion\Rabbitmq;


use Illuminate\Queue\QueueManager;

class Manager
{
    /**
     * @var QueueManager
     */
    private $manager;

    /**
     * Manager constructor.
     * @param QueueManager $manager
     */
    public function __construct(QueueManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $connection
     * @param array $messages
     * @param $queue
     * @return int Number of pushed messages
     */
    public function rawStack($connection, array $messages, $queue): int
    {
        $counter = 0;

        foreach ($messages as $message) {
            $result = $this->raw($connection, $message, $queue);

            if ($result) {
                $counter++;
            }
        }

        return $counter;
    }

    /**
     * @param $connection
     * @param $message
     * @param $queue
     * @return mixed
     */
    public function raw($connection, $message, $queue)
    {
        return $this->manager->connection($connection)->pushRaw($message, $queue);
    }
}
<?php

namespace Ingestion\Rabbitmq;


use Illuminate\Foundation\Application;

class Indexation
{
    /**
     * The message pattern for sprintf
     */
    const MESSAGE = '{"message":{"action":"%1$s","version":4,"id":"%2$s","objectType":"%3$s","extra":[]}}';

    /**
     * Allowed actions and types
     */
    const ALLOWED_ACTIONS = ['updateSingle', 'updateBatch'];
    const ALLOWED_TYPES = ['movies', 'audiobooks', 'books', 'albums'];

    /**
     * Connection name
     */
    const CONNECTION = 'indexation';

    /**
     * Queue name
     *
     * @var string
     */
    private $queue;

    /**
     * @var Manager
     */
    private $queueManager;

    /**
     * Indexation constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->queueManager = $manager;
        $this->queue = config('queue.connections.indexation.queue');
    }

    /**
     * @param $action
     * @param $type
     * @param $ids
     * @return int
     */
    public function push(string $action, string $type, string $ids): int
    {
        if (!\in_array($action, self::ALLOWED_ACTIONS, true) || !\in_array($type, self::ALLOWED_TYPES, true)) {
            throw new \RuntimeException("Invalid values of 'type' or 'action'.");
        }

        $ids = explode(',', str_replace(' ', '', $ids));
        $messages = [];

        foreach ($ids as $id) {
            if ($id) {
                $message = sprintf(self::MESSAGE, $action, $id, $type);

                $messages[] = $message;
            }
        }

        return $this->queueManager->rawStack(self::CONNECTION, $messages, $this->queue);
    }
}
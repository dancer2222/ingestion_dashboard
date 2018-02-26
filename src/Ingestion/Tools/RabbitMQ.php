<?php

namespace Ingestion\Tools;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitMQ
 * @package Ingestion\Tools
 */
class RabbitMQ
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var
     */
    private $queue;

    /**
     * RabbitMQ constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        if (!$config['host']) {
            throw new \Exception('Host cannot be empty');
        }

        if (!$config['port']) {
            throw new \Exception('Port cannot be empty');
        }

        if (!$config['user']) {
            throw new \Exception('User cannot be empty');
        }

        if (!$config['password']) {
            throw new \Exception('Password cannot be empty');
        }

        if (!$config['queue']) {
            throw new \Exception('Queue cannot be empty');
        }
        $this->queue = $config['queue'];
        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password']);

        $this->channel = $this->connection->channel();
    }

    /**
     * @param string|null $queue
     *
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function createChanel(string $queue = null)
    {
        if (!$queue) {
            $this->channel->queue_declare($this->queue, false, true, false, false);
        } else {
            $this->channel->queue_declare($queue, false, true, false, false);
        }

        return $this->channel;
    }

    /**
     * @return array
     */
    public function readMessage()
    {
        $messages = [];
        list($this->queue, $countMessages) = $this->channel->queue_declare($this->queue, false, true, false, false);
        for ($i = 0; $i < $countMessages; $i++) {
            $messages []=$this->channel->basic_get($this->queue, true, null)->body;
        }

        return $messages;
    }

    /**
     * @param $message
     * @param $config
     * @return $this
     */
    public function putMessage($message, $config)
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $config['queue']);

        return $this;
    }

    /**
     * Close connection
     */
    public function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
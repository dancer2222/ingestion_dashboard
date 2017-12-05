<?php

namespace Ingestion\Tools;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    private $connection;
    private $queue;

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

        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password']);

        $this->channel = $this->connection->channel();
        $this->createChanel();
    }

    public function createChanel(string $queue = null)
    {
        if (!$queue) {
            $this->channel->queue_declare($this->queue, false, true, false, false);
        } else {
            $this->channel->queue_declare($queue, false, true, false, false);
        }

        return $this->channel;
    }


    public function putMessage($message)
    {
        $msg = new AMQPMessage($this->channel, $message);
        $this->channel->basic_publish($msg);

        return $this;
    }

    public function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
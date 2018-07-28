<?php

namespace Ingestion\LibraryThing\Xml;


use Psr\Log\LoggerInterface;

abstract class ParserAbstract implements ParserInterface
{
    /**
     * @var \XMLReader
     */
    protected $reader;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array Array of error messages
     */
    protected $errors = [];

    /**
     * @var array Batches to dispatch to the queue
     */
    protected $batches = [];

    /**
     * @var int
     */
    protected $batchesCounter = 0;

    /**
     * Limit items per batch
     *
     * @var int $limit
     */
    protected $limit = 0;

    /**
     * @var string Queue name
     */
    protected $queue = '';

    /**
     * ParserAbstract constructor.
     * @param string $filepath
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(string $filepath, LoggerInterface $logger)
    {
        if (!file_exists($filepath) || !is_file($filepath)) {
            throw new \RuntimeException("File: '$filepath' doesn't exist or it isn't file.");
        }

        $this->reader = new \XMLReader();
        $this->reader->open($filepath, 'utf-8', LIBXML_BIGLINES | LIBXML_PARSEHUGE);

        $this->logger = $logger;
    }

    /**
     * Handle xml file
     */
    abstract protected function handle(): void;

    /**
     * Dispatch data to the queue
     */
    abstract protected function dispatch(): void;

    /**
     * Parse xml file using 'handle' method.
     */
    public function parse(): void
    {
        $this->checkSettings();
        $this->handle();
    }

    /**
     * Check if we set all needed settings.
     * E.g. set queue name or limit
     */
    protected function checkSettings(): void
    {
        if (!$this->limit) {
            throw new \RuntimeException('Limit is not set. (use $this->setLimit() to set it)');
        }

        if (!$this->queue) {
            throw new \RuntimeException('Queue name is not set. (use $this->setQueue() to set it)');
        }
    }

    /**
     * @param string $message
     */
    protected function addError(string $message)
    {
        $this->errors[] = $message;
    }

    /**
     * Add items to batch and dispatch batches if they have reached the limit
     *
     * @param array $data
     */
    protected function addToBatch(array $data): void
    {
        $this->batchesCounter++;
        $this->batches[] = $data;

        if ($this->batchesCounter >= $this->limit) {
            $this->dispatch();

            $this->batchesCounter = 0;
            $this->batches = [];
        }
    }

    /**
     * Set limit of items per batch
     *
     * @param int $limit
     */
    protected function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Set name of queue
     *
     * @param string $queue
     */
    protected function setQueue(string $queue): void
    {
        $this->queue = $queue;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if ($this->batches) {
            $this->dispatch();
        }

        $this->reader->close();
    }
}

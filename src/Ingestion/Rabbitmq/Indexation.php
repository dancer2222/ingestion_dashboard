<?php

namespace Ingestion\Rabbitmq;

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

    /**
     * Allowed types by batch indexation
     */
    const ALLOWED_TYPES_BATCH = ['albums', 'books', 'audiobooks', 'games', 'movies'];

    /**
     * Allowed types by single indexation
     */
    const ALLOWED_TYPES_SINGLE = [
        'albums', 'books', 'audiobooks', 'movies', 'games',
        'songs', 'album_artist', 'song_artist', 'album_genre', 'album_tag', 'song_tag',
        'book_artist', 'book_author', 'book_genre', 'book_tag',
        'audiobook_author', 'audiobook_narrator', 'audiobook_genre', 'audiobook_tag',
        'game_developer', 'game_genre', 'game_tag',
        'movie_actor', 'movie_director', 'movie_producer', 'movie_writer', 'movie_genre', 'movie_tag'
    ];

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
        if (!\in_array($action, self::ALLOWED_ACTIONS, true)
            || ($action === 'updateBatch' && !\in_array($type, self::ALLOWED_TYPES_BATCH, true))
            || ($action === 'updateSingle' && !\in_array($type, self::ALLOWED_TYPES_SINGLE, true))) {
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

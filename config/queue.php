<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the default queue driver.
    |
    | Supported: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'default' => env('QUEUE_DRIVER', 'rabbitmq'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => 'your-public-key',
            'secret' => 'your-secret-key',
            'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
            'queue' => 'your-queue-name',
            'region' => 'us-east-1',
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'rabbitmq' => [
            'driver' => 'rabbitmq',
            'dsn' => null,
            'host' => env('RABBITMQ_HOST', '127.0.0.1'),
            'port' => env('RABBITMQ_PORT', 5672),

            'queue' => env('RABBITMQ_QUEUE'),
            'vhost' => env('RABBITMQ_VHOST', '/'),

            'login'	=> env('RABBITMQ_LOGIN', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),

            'options' => [

                'exchange' => [

                    'name' => env('RABBITMQ_EXCHANGE_NAME'),

                    /*
                    * Determine if exchange should be created if it does not exist.
                    */
                    'declare' => true,

                    /*
                    * Read more about possible values at https://www.rabbitmq.com/tutorials/amqp-concepts.html
                    */
                    'type' => env('RABBITMQ_EXCHANGE_TYPE', \Interop\Amqp\AmqpTopic::TYPE_DIRECT),
                    'passive' => false,
                    'durable' => true,
                    'auto_delete' => false,
                    'arguments' => env('RABBITMQ_EXCHANGE_ARGUMENTS'),
                ],

                'queue' => [

                    /*
                    * The name of default queue.
                    */
                    'name' => env('RABBITMQ_QUEUE', 'default'),

                    /*
                    * Determine if queue should be created if it does not exist.
                    */
                    'declare' => true,

                    /*
                    * Determine if queue should be binded to the exchange created.
                    */
                    'bind' => true,

                    /*
                    * Read more about possible values at https://www.rabbitmq.com/tutorials/amqp-concepts.html
                    */
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'arguments' => env('RABBITMQ_QUEUE_ARGUMENTS'),
                ],
            ],

            /*
             * Determine the number of seconds to sleep if there's an error communicating with rabbitmq
             * If set to false, it'll throw an exception rather than doing the sleep for X seconds.
             */
            'sleep_on_error' => env('RABBITMQ_ERROR_SLEEP', 5),
            'ssl_params' => [
                'ssl_on' => env('RABBITMQ_SSL', false),
                'cafile' => env('RABBITMQ_SSL_CAFILE', null),
                'local_cert' => env('RABBITMQ_SSL_LOCALCERT', null),
                'local_key' => env('RABBITMQ_SSL_LOCALKEY', null),
                'verify_peer' => env('RABBITMQ_SSL_VERIFY_PEER', true),
                'passphrase' => env('RABBITMQ_SSL_PASSPHRASE', null),
            ],
        ],

        'indexation' => [
            'driver' => 'rabbitmq',
            'dsn' => null,
            'factory_class' => \Enqueue\AmqpLib\AmqpConnectionFactory::class,

            'host' => env('RABBITMQ_HOST', '127.0.0.1'),
            'port' => env('RABBITMQ_PORT', 5672),

            'queue' => env('RABBITMQ_INDEXATION_QUEUE', 'batch-to-index'),
            'vhost' => env('RABBITMQ_INDEXATION_VHOST', 'prod-capi-index-us'),

            'login'	=> env('RABBITMQ_LOGIN', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),

            'options' => [
                'exchange' => [
                    'name' => env('RABBITMQ_EXCHANGE_NAME'),
                    'declare' => true,
                    'type' => env('RABBITMQ_EXCHANGE_TYPE', \Interop\Amqp\AmqpTopic::TYPE_DIRECT),
                    'passive' => false,
                    'durable' => true,
                    'auto_delete' => false,
                    'arguments' => env('RABBITMQ_EXCHANGE_ARGUMENTS'),
                ],
                'queue' => [
                    'name' => env('RABBITMQ_QUEUE', 'default'),
                    'declare' => true,
                    'bind' => true,
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'arguments' => env('RABBITMQ_QUEUE_ARGUMENTS'),
                ],
            ],
            'sleep_on_error' => 5,
            'ssl_params' => [
                'ssl_on' => false,
                'cafile' => null,
                'local_cert' => null,
                'local_key' => null,
                'verify_peer' => true,
                'passphrase' => null,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];

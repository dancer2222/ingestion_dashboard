<?php

return [
    'links'    => [
        'playster' => [
            'prod' => 'https://play.playster.com/',
            'qa'   => 'https://qa-playster-v3-3rdparty.playster.com/'
        ],
        'aws'      => [
            'cp'     => 'aws s3 cp s3://',
            'ls'     => 'aws s3 ls s3://',
            'bucket' => [
                'books'  => 'playster-book-service-dump',
                'movies' => 'playster-content-ingestion'
            ]
        ],
        'image'    => [
            'book'      => 'https://prod-image-resizer-v1-cdn1.playster.com/book/',
            'movie'     => 'https://prod-image-resizer-v1-cdn1.playster.com/movie/',
            'game'      => 'https://prod-image-resizer-v1-cdn1.playster.com/game/',
            'album'     => 'https://prod-image-resizer-v1-cdn1.playster.com/album/7digital/',
            'audiobook' => 'https://prod-image-resizer-v1-cdn1.playster.com/audiobook/findaway/square/'
        ]
    ],
    'rabbitMq' => [
        'host'     => '10.0.10.63',
        'port'     => '5672',
        'user'     => 'guest',
        'password' => 'guest',
        'queue'    => 'ingestion-tools'
    ]
];
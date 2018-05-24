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
        'image'    => 'https://prod-image-resizer-v1-cdn1.playster.com/'
    ]
];
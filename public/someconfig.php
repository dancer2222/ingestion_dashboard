<?php
return [
    'types'    => [
        0 => 'core',
        1 => 'albums',
        2 => 'books',
        3 => 'movies',
        4 => 'audiobooks',
    ],
    'actions'  => [
        0 => 'activate',
        1 => 'deactivate',
        2 => 'check',
        3 => 'fix',
        4 => 'report',
        5 => 'reingest',
        6 => 'make',
    ],
    'commands' => [
        'core:make:blankTool'     => 'JoMedia\\Tools\\ToolBuilder',
        'movies:fix:duplicateIds' => 'Tools\\Movies\\MoviesFixDuplicateIds',
        'movies:activate:byIds'   => 'Tools\\MoviesActivateByIds',
        'movies:deactivate:byIds' => 'Tools\\MoviesDeactivateByIds',
        'albums:check:covers'     => 'Tools\\AlbumsCheckCovers',
    ],
    'params'   => [
        'core:make:blankTool'     => [
            'options'   => [],
            'arguments' => [],
        ],
        'movies:fix:duplicateIds' => [
            'options'   => [
                'batch' => [
                    'description' => null,
                    'isRequired'  => true,
                ],
            ],
            'arguments' => [],
        ],
        'movies:activate:byIds'   => [
            'options'   => [
                'ids' => [
                    'description' => null,
                    'isRequired'  => true,
                ],
            ],
            'arguments' => [],
        ],
        'movies:deactivate:byIds' => [
            'options'   => [
                'ids' => [
                    'description' => null,
                    'isRequired'  => true,
                ],
            ],
            'arguments' => [],
        ],
        'albums:check:covers'     => [
            'options'   => [
                'ids' => [
                    'description' => null,
                    'isRequired'  => true,
                ],
            ],
            'arguments' => [
                'full' => [
                    'description' => null,
                    'isRequired'  => false,
                ],
            ],
        ],
    ],
    'url'      => 'api/v1/tools/config',
];

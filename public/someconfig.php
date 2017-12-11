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
        'core:make:blankTool'  => '\\JoMedia\\Tools\\ToolBuilder::class',
        'core:make:blankTool1'  => [
            '--name' => 'Descriptfsdfsdfdsfdf',
            '--file' => 'Descriptfsdfsdfdsfdf',
        ],
        'core:make:blankTool2'  => [
            '--name' => 'Descriptfsdfsdfdsfdf',
            '--file' => 'Descriptfsdfsdfdsfdf',
        ],
        'core:make:blankTool3'  => [
            '--name' => 'Descriptfsdfsdfdsfdf',
            '--file' => 'Descriptfsdfsdfdsfdf',
        ],
        'core:check:blankTool' => '\\JoMedia\\Tools\\ToolBuilder::class',
        'albums:fix:blankTool' => '\\JoMedia\\Tools\\ToolBuilder::class',
    ],
];

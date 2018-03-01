<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'brightcove' => [
        'account_id' => env('BRIGHTCOVE_ACCOUNT_ID'),
        'client_id' => env('BRIGHTCOVE_CLIENT_ID'),
        'client_secret' => env('BRIGHTCOVE_CLIENT_SECRET'),
    ],

    'rabbitAdjuster' => [
        'host'     => env('RABBITMQ_ADJUSTER_HOST'),
        'port'     => env('RABBITMQ_ADJUSTER_PORT'),
        'user'     => env('RABBITMQ_ADJUSTER_LOGIN'),
        'password' => env('RABBITMQ_ADJUSTER_PASSWORD'),
        'queue'    => env('RABBITMQ_ADJUSTER_QUEUE')
    ],

    'rabbitMq' => [
        'host'     => env('RABBITMQ_HOST'),
        'port'     => env('RABBITMQ_PORT'),
        'user'     => env('RABBITMQ_LOGIN'),
        'password' => env('RABBITMQ_PASSWORD'),
        'queue'    => env('RABBITMQ_QUEUE')
    ]

	'google' => [
		'client_id' => env('GOOGLE_API_CLIENT_ID'),
		'client_secret' => env('GOOGLE_API_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_API_REDIRECT_URI'),
	],

];

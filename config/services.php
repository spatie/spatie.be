<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'token' => env('GITHUB_TOKEN'),
    ],
    'rss' => [
        'https://freek.dev/feed/originals',
        'https://sebastiandedeyne.com/feed/articles',
        'https://www.stitcher.io/rss',
        'https://alexvanderbist.com/feed',
    ],
    'instagram' => [
        'token' => env('INSTAGRAM_TOKEN'),
    ],
    'patreon' => [
        'id' => env('PATREON_CLIENT_ID'),
        'secret' => env('PATREON_SECRET'),
    ],

    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    ],
    'google_api' => [
        'key' => env('GOOGLE_API_KEY'),
    ],

    'github' => [
        'token' => env('GITHUB_TOKEN'),
    ],

];

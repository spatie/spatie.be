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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),

        'message_stream_id' => 'outbound',
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'username' => env('GITHUB_USERNAME'),
        'token' => env('GITHUB_TOKEN'),
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
        'docs_access_token' => env('GITHUB_ACCESS_TOKEN'),
        'webhook_secret' => env('GITHUB_WEBHOOK_SECRET'),
    ],

    'vimeo' => [
        'client' => env('VIMEO_CLIENT'),
        'secret' => env('VIMEO_SECRET'),
        'access' => env('VIMEO_ACCESS'),
    ],

    'rss' => [
        'https://flareapp.io/feed',
        'https://mailcoach.app/blog/feed',
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

    'promo_codes' => [
        'package_training' => env('PROMO_CODE_PACKAGE_TRAINING'),
    ],

    'mailcoach' => [
        'token' => env('MAILCOACH_TOKEN'),
    ],

    'helpSpace' => [
        'secret' => env('HELP_SPACE_SECRET')
    ],

];

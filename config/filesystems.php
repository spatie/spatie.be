<?php

/*
 * On Laravel Cloud, the public and the private bucket are attached to the environment as the
 * `cloud-public` and `cloud-private` disks. These disks keep the names used by the app, but
 * store their files in a directory of one of those buckets.
 */
$bucketDisks = [
    'medialibrary' => [
        'driver' => 'scoped',
        'disk' => 'cloud-public',
        'prefix' => 'medialibrary',
        'visibility' => 'public',
    ],

    'public' => [
        'driver' => 'scoped',
        'disk' => 'cloud-public',
        'prefix' => 'storage',
        'visibility' => 'public',
    ],

    'docs-assets' => [
        'driver' => 'scoped',
        'disk' => 'cloud-public',
        'prefix' => 'docs',
        'visibility' => 'public',
    ],

    'docs' => [
        'driver' => 'scoped',
        'disk' => 'cloud-private',
        'prefix' => 'docs',
    ],

    'purchasable_downloads' => [
        'driver' => 'scoped',
        'disk' => 'cloud-private',
        'prefix' => 'purchasable-downloads',
    ],
];

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => array_merge([
        'backups' => [
            'driver' => 'local',
            'root' => storage_path('app/backups'),
        ],

        'github_ads' => [
            'driver' => env('GITHUB_ADS_DISK_DRIVER'),
            'root' => env('GITHUB_ADS_DISK_ROOT') ? storage_path(env('GITHUB_ADS_DISK_ROOT')) : '',
            'key' => env('GITHUB_ADS_DISK_KEY'),
            'secret' => env('GITHUB_ADS_DISK_SECRET'),
            'region' => env('GITHUB_ADS_DISK_REGION'),
            'bucket' => env('GITHUB_ADS_DISK_BUCKET'),
            'url' => env('GITHUB_ADS_DISK_URL'),
            'options' => [
                'CacheControl' => 'max-age=120, s-maxage=120',
            ],
        ],


        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'purchasable_downloads' => [
            'driver' => 'local',
            'root' => storage_path('app/purchasable_downloads'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'docs' => [
            'driver' => 'local',
            'root' => storage_path('docs'),
        ],

        'docs-assets' => [
            'driver' => 'local',
            'root' => public_path('docs'),
            'url' => '/docs',
            'visibility' => 'public',
        ],

        'guidelines' => [
            'driver' => 'local',
            'root' => resource_path('views/front/pages/guidelines/pages'),
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'medialibrary' => [
            'driver' => 'local',
            'root' => public_path('images/medialibrary'),
            'url' => '/images/medialibrary',
            'visibility' => 'public',
        ],
    ], laravel_cloud() ? $bucketDisks : []),

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

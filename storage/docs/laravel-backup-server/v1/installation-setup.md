---
title: Installation & setup
weight: 4
---

laravel-backup-server can be installed via composer:

```bash
composer require spatie/laravel-backup-server
```

### Migrate the database

You need to publish and run the migrations to create the `stored_events` table:

```bash
php artisan vendor:publish --provider="Spatie\BackupServer\BackupServerServiceProvider" --tag="backup-server-migrations"
php artisan migrate
```

### Publish the config file

You must publish the config file with this command:

```bash
php artisan vendor:publish --provider="Spatie\BackupServer\BackupServerServiceProvider" --tag="backup-server-config"
```

This is the default content of the config file that will be published at `config/backup-server.php`:

```php
return [
    /*
     * This is the date format that will be used when displaying time related information on backups.
     */
    'date_format' => 'Y-m-d H:i',
    
    'notifications' => [

        /*
         * Backup server sends out notifications on several events. Out of the box, mails and Slack messages
         * can be sent.
         */
        'notifications' => [
            \Spatie\BackupServer\Notifications\Notifications\BackupCompletedNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\BackupFailedNotification::class => ['mail'],

            \Spatie\BackupServer\Notifications\Notifications\CleanupForSourceCompletedNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\CleanupForSourceFailedNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\CleanupForDestinationCompletedNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\CleanupForDestinationFailedNotification::class => ['mail'],

            \Spatie\BackupServer\Notifications\Notifications\HealthySourceFoundNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\UnhealthySourceFoundNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\HealthyDestinationFoundNotification::class => ['mail'],
            \Spatie\BackupServer\Notifications\Notifications\UnhealthyDestinationFoundNotification::class => ['mail'],
        ],

        /*
         * Here you can specify the notifiable to which the notifications should be sent. The default
         * notifiable will use the variables specified in this config file.
         */
        'notifiable' => \Spatie\BackupServer\Notifications\Notifiable::class,

        'mail' => [
            'to' => 'your@example.com',

            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],

        'slack' => [
            'webhook_url' => '',

            /*
             * If this is set to null the default channel of the web hook will be used.
             */
            'channel' => null,

            'username' => null,

            'icon' => null,

        ],
    ],

    'monitor' => [
        /*
         * These checks will be used to determine whether a source is health. The given value will be used
         * when there is no value for the check specified on either the destination or the source.
         */
        'source_health_checks' => [
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Source\MaximumStorageInMB::class => 5000,
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Source\MaximumAgeInDays::class => 1,
        ],

        /*
         * These checks will be used to determine whether a destination is healthy. The given value will be used
         * when there is no value for the check specified on either the destination or the source.
         */
        'destination_health_checks' => [
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Destination\DestinationReachable::class,
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Destination\MaximumDiskCapacityUsageInPercentage::class => 90,
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Destination\MaximumStorageInMB::class => 0,
            \Spatie\BackupServer\Tasks\Monitor\HealthChecks\Destination\MaximumInodeUsageInPercentage::class => 90,
        ],
    ],

    /*
     * This class is responsible for deciding when sources should be backed up. An valid backup scheduler
     * is any class that implements `Spatie\BackupServer\Tasks\Backup\Support\BackupScheduler\BackupScheduler`.
     */
    'scheduler' => \Spatie\BackupServer\Tasks\Backup\Support\BackupScheduler\DefaultBackupScheduler::class,
];
```

### Schedule the commands

You must schedule these commands in `app\Console\Kernel.php`:

```php
// in app\Console\Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->command('backup-server:dispatch-backups')->hourly();
    $schedule->command('backup-server:cleanup')->daily();
    $schedule->command('backup-server:monitor')->daily();
}
```

### Configure the queues

Backup server uses queued jobs to perform various tasks. We recommend setting up the queues. Any driver will do, just don't use the `sync` driver.

When you use horizon we recommend adding a separate queue connection so the `retry_after` can be set to a high value.

```php
// in config/queue.php

'connections' => [
    'backup-server-redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => \Carbon\CarbonInterval::day(1)->totalSeconds,
        'block_for' => null,
    ],
```

In the backup server configuration you must set the `queue_connection` to `backup-server-redis`.

```php
// in config/backup-server.php

'connection' => 'backup-server-redis',
```

In the Horizon config you can add extra configuration for backup server.

```php
// in config/horizon.php

'environments' => [
    'production' => [
        // ..

        'backup-server' => [
            'connection' => 'backup-server-redis',
            'queue' => ['backup-server', 'backup-server-backup', 'backup-server-cleanup'],
            'balance' => 'auto',
            'processes' => 3,
            'tries' => 1,
            'timeout' => \Carbon\CarbonInterval::day()->totalSeconds,
        ],
    ],

    'local' => [
        // ...

        'backup-server' => [
            'connection' => 'backup-server-redis',
            'queue' => ['backup-server', 'backup-server-backup', 'backup-server-cleanup'],
            'balance' => 'auto',
            'processes' => 3,
            'tries' => 1,
            'timeout' => \Carbon\CarbonInterval::day()->totalSeconds,
        ],
    ],
],
```


## Setting up block storage

Backup server can copy the contents of several several servers onto block storage. Make sure that the system where you run backup server on has plenty of block storage available.

---
title: Sending notifications
weight: 1
---

The package leverages Laravel's native notifications to let you know that your backups are ok, or not. Out of the box it can send notifications via mail and Slack.

## Configuration

This is the portion of the configuration that will determine when and how notifications will be sent.

```php
// config/backup-server.php
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
```

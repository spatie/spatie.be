---
title: Adding extra notification channels
weight: 2
---

By default the package send notifications via email or Slack. You can add an extra notification channels such as Telegram or native mobile push notification, etc.
 
The community already has built notification channels package for a lot of services:  [http://laravel-notification-channels.com](http://laravel-notification-channels.com).
 
In the following example we're going to add the Pusher push notifications channel. Other notification drivers can be added in the same way.

### 1. Install the notification channel driver

For Pusher Push notifications, require this package

```php
laravel-notification-channels/pusher-push-notifications
```

After composer has pulled in the package, just follow [the installation instructions of the package](https://github.com/laravel-notification-channels#installation) to complete the installation.


### 2. Creating your own custom notification

Let say you want to be notified via Pusher push notifications when a backup fails. To make this happen you'll need to create your own `BackupFailed` notification class like the one below:

```php
namespace App\Notifications;

use Spatie\BackupServer\Notifications\Notifications\BackupFailedNotification as BaseNotification;
use NotificationChannels\PusherPushNotifications\Message;

class BackupFailedNotification extends BaseNotification
{
    public function toPushNotification($notifiable)
    {
        return Message::create()
            ->iOS()
            ->badge(1)
            ->sound('fail')
            ->body("The backup of {$this->sourceName()} has failed");
    }
}
```

### 3. Register your custom notification in the config file

The last thing you need to do is register your custom notification in the config file.

```php
// config/backup.php
use \NotificationChannels\PusherPushNotifications\Channel as PusherChannel

...

    'notifications' => [

        'notifications' => [
            \App\Notifications\BackupHasFailed::class => ['mail', 'slack', PusherChannel::class],
            ...
```

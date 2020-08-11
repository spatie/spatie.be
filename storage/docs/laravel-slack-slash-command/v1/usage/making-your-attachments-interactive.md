---
title: Making your attachments interactive
weight: 4
---

On top of adding attachments to your messages, you can also make your attachments interactive.

Take a look at this response on Slack:

<img src="../../images/buttons.png">

This is how you would build that up

```php
$this->respondToSlack('')
    ->withAttachment(Attachment::create()
        ->setColor('good')
        ->setText('This is good!')
        ->setFallback('good-message')
        ->setCallbackId('good-1')
        ->addAction(Action::create('cool button', 'A Cool Button', 'button'))
    );
```

Make sure you use the correct classes:
```php
use Spatie\SlashCommand\Attachment;
use Spatie\SlashCommand\AttachmentField;
```

Take a look at [Slacks documentation on interactive messages](https://api.slack.com/interactive-messages) to learn what's possible. Please note that at this time only buttons are supported, and menus are not.

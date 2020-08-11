---
title: Making your response look good
weight: 3
---

In various examples giving in these you'll see that `respondToSlack()` is used to send some text back as a response. But you can also add some attachments.

Take a look at this response on Slack:

<img src="../../images/attachments.png">

This is how you would build that up

```php
$this->respondToSlack('')
    ->withAttachment(Attachment::create()
        ->setColor('good')
        ->setText('This is good!')
    )
    ->withAttachment(Attachment::create()
        ->setColor('warning')
        ->setText('Warning!')
    )
    ->withAttachment(Attachment::create()
        ->setColor('danger')
        ->setText('DANGER DANGER!')
    )
    ->withAttachment(Attachment::create()
        ->setColor('#439FE0')
        ->setText('This was a hex value')
    );
```

Take a look at [Slacks documentation on attachments](https://api.slack.com/docs/message-attachments) to learn what's possible.

---
title: Responding to multiple commands
weight: 3
---

You may choose to set up multiple slack commands. On the integrations settings on slack.com you should let them all point to the `url` you configured in `app/config/laravel-slack-slash-command`.

Image you've created two slack commands `/jaime` and `/johnsnow`

```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class Jaime extends BaseHandler
{

    public function canHandle(Request $request): bool
    {
        return $request->command == 'jaime';
    }

    public function handle(Request $request): Response
    {
        return $this->respondToSlack("A Lannister always pays his debts");
    }
}
```

```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class JohnSnow extends BaseHandler
{

    public function canHandle(Request $request): bool
    {
        return $request->command == 'johnsnow';
    }

    public function handle(Request $request): Response
    {
        return $this->respondToSlack("I know nothing");
    }
}
```

You'll see a response `A Lannister always pays his debts` after issueing the `/jaime` command, and `I know nothing` after issuing the `/johnsnow` command.

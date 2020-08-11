---
title: Sending a basic response
weight: 2
---

Whenever a user types in a slash command Slack will send an http request to the Laravel app. Keep in mind that you have only 3 seconds to respond. If handling the request takes longer than that you should use [delayed responses](/laravel-slack-slash-command/v1/advanced-usage/sending-delayed-responses).

Whenever a request from slack hits the Laravel app the package will go over all classes in the `handlers` key of the config file to see which one should send a response. Let's review how you can create your own handler.

Here's a simple example:

```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class Hodor extends BaseHandler
{
    /**
     * If this function returns true, the handle method will get called.
     *
     * @param \Spatie\SlashCommand\Request $request
     *
     * @return bool
     */
    public function canHandle(Request $request): bool
    {
        return true;
    }

    /**
     * Handle the given request. Remember that Slack expects a response
     * within three seconds after the slash command was issued. If
     * there is more time needed, dispatch a job.
     * 
     * @param \Spatie\SlashCommand\Request $request
     * 
     * @return \Spatie\SlashCommand\Response
     */
    public function handle(Request $request): Response
    {
        return $this->respondToSlack("Hodor, hodor...");
    }
}
```

That handler must be registered in the config file.

```php
// app/config/laravel-slack-slash-command
    'handlers' => [
        App\SlashCommandHandlers\Hodor::class,
        ...
    ], 
```

Now whenever you type in your slash command, you'll see that it'll response with `Hodor, hodor...`.

Let's create a slightly more advanced command.

```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class Repeat extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return starts_with($request->text, 'repeat');
    }

    public function handle(Request $request): Response
    {   
        $textWithoutRepeat = substr($request->text, 7)
        
        return $this->respondToSlack("You said {$textWithoutRepeat}");
    }
}
```

Let's register this handler as well.

```php
// app/config/laravel-slack-slash-command

    'handlers' => [
        App\SlashCommandHandlers\Repeat::class,
        App\SlashCommandHandlers\Hodor::class,
        ...
    ],    
```

If you type in `/your-command repeat Hi, everybody` in a slack channel now, you'll get a response `Hi, everybody` back. When you type in `/your-command this does not exists` you'll get a response `Hodor, hodor...` because the `Hodor` handler is the first one which `canHandle`-method returns `true`.

## The request object

Notice that `Spatie\SlashCommand\Request` being past in `canHandle` and `handle` in the handler of the previous example? It contains all data that's being passed by Slack to our Laravel app. These are it's most important properties:

- `command`: the command name without the `/` that the user typed in. In our previous example this would be `your-command`.
- `text`: all text text after the command. In our the example above this would be `repeat Hi, everybody`.
- `userName`: the Slack username of the person that typed in the command
- `userId`: the Slack user id of the person that typed in the command
- `channelName`: the name of the channel where the user typed in the command
- `teamDomain`: the name of the Slack subdomain. So if your team is on `example.slack.com` this would be `example`.

## Visibility of the response

By default the response will be sent to the user who typed in the original message. If you want the response to be visible to all users in the channel you can do this:

```php
    public function handle(Request $request): Response
    {
        return $this
           ->respondToSlack("Hodor, hodor...")
           ->displayResponseToEveryoneOnChannel();
    }
```

There are a lot of ways to format your message. Take a look at the docs on [formatting responses](https://docs.spatie.be/laravel-slack-slash-command/v1/usage/making-your-response-look-good) to learn more.

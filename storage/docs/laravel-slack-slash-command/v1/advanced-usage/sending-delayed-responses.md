---
title: Sending delayed responses
weight: 1
---

Whenever a user types in a slash command Slack will send an http request to the Laravel app. Keep in mind that you have only 3 seconds to respond. After that initial fast response you're allowed to send 5 more responses in the next 30 minutes for the command. Let's see how that works.

Imagine you need to call a slow API to get a response for a slash command. Let's first create a handler that will send the initial fast response.


```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class SlowApi extends BaseHandler
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
        return starts_with($request->text, 'give me the info');
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
        $this->dispatch(new SlowApiJob());
    
        return $this->respondToSlack("Looking that up for you...");
    }
}
```

Notice that we're dispatching a job right before sending a response. Behind the scenes Laravel will queue that job (make sure you've set up a queue driver other than `sync`).

This is how that `SlowApiJob` would look like.

```php
namespace App\SlashCommand\Jobs;

use Spatie\SlashCommand\Jobs\SlashCommandResponseJob;

class SlowApiJobJob extends SlashCommandResponseJob
{
    // notice here that Laravel will automatically inject dependencies here
    public function handle(MyApi $myApi)
    {
        $response = $myApi->fetchResponse();
        
        $this
           ->respondToSlack("Here is your response: {$response}")
           ->send();
    }
}
```

When a user types in `/your-command get me the info` a quick response `Looking that info for you...` will be displayed. After a little while, when `MyApi` has done it's job `Here is your response: ...` will be sent to the channel.

Notice that, unlike in the `Handlers` you'll need to call `send()` after the `respondToSlack`-method. You may send up to five responses in a timespan of 30 minutes in this job.

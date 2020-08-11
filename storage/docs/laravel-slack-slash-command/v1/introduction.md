---
title: Introduction
weight: 1
---

This package makes it easy to make your Laravel app respond to [Slack's Slash commands](https://api.slack.com/slash-commands). 

Once you've setup your Slash command over at Slack and installed this package into a Laravel app you can create handlers that can handle a slash command. Here's an example of such a handler that will send a response back to Slack.

```php
namespace App\SlashCommandHandlers;

use App\SlashCommand\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class CatchAll extends BaseHandler
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
        return $this->respondToSlack("You have typed this text: `{$request->text}`");
    }
}
```


The package also provides many options to format a response. It also can respond to Slack from within a queued job.

## We have badges!

<section class="article_badges">
    <a href="https://packagist.org/packages/spatie/laravel-slack-slash-command"><img src="https://img.shields.io/packagist/v/spatie/laravel-slack-slash-command.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/spatie/laravel-slack-slash-command/blob/master/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://travis-ci.org/spatie/laravel-slack-slash-command"><img src="https://img.shields.io/travis/spatie/laravel-slack-slash-command/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://insight.sensiolabs.com/projects/20a38dd4-06a0-401f-bd51-1d3f05fcdff5"><img src="https://img.shields.io/sensiolabs/i/20a38dd4-06a0-401f-bd51-1d3f05fcdff5.svg?style=flat-square" alt="SensioLabsInsight"></a>
    <a href="https://scrutinizer-ci.com/g/spatie/laravel-slack-slash-command"><img src="https://img.shields.io/scrutinizer/g/spatie/laravel-slack-slash-command.svg?style=flat-square" alt="Quality Score"></a>
    <a href="https://packagist.org/packages/spatie/laravel-slack-slash-command"><img src="https://img.shields.io/packagist/dt/spatie/laravel-slack-slash-command.svg?style=flat-square" alt="Total Downloads"></a>
</section>

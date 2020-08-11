---
title: Using signature handlers
weight: 2
---

A console command in Laravel can make use of a `signature` to set expectations on the input. A signature allows you to <a href="https://laravel.com/docs/5.2/artisan#command-io">">easily define arguments and options</a>. 

If you let your handler extend `Spatie\SlashCommand\Handlers\SignatureHandler` you can make use of a `$signature` and the `getArgument` and `getOption` methods to get the values of arguments and options.  

Let's take a look at an example.

```php
namespace App\SlashCommandHandlers;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\SignatureHandler;

class SendEmail extends SignatureHandler
{
    protected $signature = "your-command email:send {to} {message} {--queue}";
    
    protected $description = "A description of what your command does. This text will be displayed in the help command.";

    public function handle(Request $request): Response
    {   
        $to = $this->getArgument('to');
    
        $message = $this->getArgument('message');
        
        $queue = $this->getOption('queue') ?? 'default';
        
        //send email message...
    }
}
```

Notice that there is no `canHandle` method present. The package will automatically determine that a command `/your-command email:send test@email.com hello` can be handled by this class.

You may use a `*` as a wildcard in the `$signature`.

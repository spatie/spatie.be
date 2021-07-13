<?php

namespace App\Console\Commands;

use App\Http\Api\Controllers\HandleGitHubPullRequestWebhookController;
use App\Http\Kernel;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class SendTestPullRequestWebhookCommand extends Command
{
    protected $signature = 'send-test-pull-request {--failed}';

    public function handle()
    {
        if (! app()->environment('local')) {
            $this->error('Not in local env');

            return;
        }

        $payload = $this->option('failed')
            ? file_get_contents(storage_path('app/pull_requests/fail.json'))
            : file_get_contents(storage_path('app/pull_requests/success.json'));

        $kernel = app(Kernel::class);

        $kernel->handle(Request::createFromBase(
            SymfonyRequest::create(
                uri: action(HandleGitHubPullRequestWebhookController::class),
                method: 'POST',
                content: $payload,
            )
        ));

        $this->info('Done');
    }
}

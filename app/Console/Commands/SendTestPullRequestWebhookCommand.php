<?php

namespace App\Console\Commands;

use App\Http\Api\Controllers\HandleGitHubPullRequestWebhookController;
use App\Http\Kernel;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class SendTestPullRequestWebhookCommand extends Command
{
    protected $signature = 'send-test-pull-request {--failed}';

    public function handle()
    {
        if (! app()->environment('local')) {
            $this->error('Not in local env');

            return;
        }

        if ($this->option('failed')) {
            $payload = file_get_contents(storage_path('app/pull_requests/fail.json'));
        } else {
            $payload = file_get_contents(storage_path('app/pull_requests/success.json'));
        }

        $kernel = app(Kernel::class);

        $kernel->handle(Request::createFromBase(
            \Symfony\Component\HttpFoundation\Request::create(
                uri: action(HandleGitHubPullRequestWebhookController::class),
                method: 'POST',
                content: $payload,
            )
        ));

        $this->info('Done');
    }
}

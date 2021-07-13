<?php

namespace App\Http\Api\Controllers;

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Spatie\EventSourcing\Commands\CommandBus;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HandleGitHubPullRequestWebhookController
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function __invoke(Request $request)
    {
        Log::info("PR webhook received");

        $this->ensureValidRequest($request);

        Log::info("PR webhook valid");

        $payload = json_decode($request->getContent(), true);

        if (! ($payload['pull_request']['merged'] ?? null)) {
            return;
        }

        Log::info("Was merged, resolving user…");

        $user = User::whereGithubId($payload['sender']['id'])->first();

        if (! $user) {
            Log::info("User not found for GH id {$payload['sender']['id']}");
            return;
        }

        Log::info("User found, dispatching command.");

        $this->bus->dispatch(RegisterPullRequest::forUser($user, $payload['pull_request']['url'] ?? ''));
    }

    protected function ensureValidRequest(Request $request): void
    {
        if (app()->environment('local')) {
            return;
        }

        $signature = $request->headers->get('X-Hub-Signature');

        if ($signature === null) {
            throw new BadRequestHttpException('Header is not set');
        }

        $signatureParts = explode('=', $signature);

        if (count($signatureParts) !== 2) {
            throw new BadRequestHttpException('Signature has an invalid format');
        }

        $knownSignature = hash_hmac('sha1', $request->getContent(), config('services.github.webhook_secret'));

        if (! hash_equals($knownSignature, $signatureParts[1])) {
            throw new UnauthorizedException('Could not verify the request signature ' . $signatureParts[1]);
        }
    }
}

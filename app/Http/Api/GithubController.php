<?php

namespace App\Http\Api;

use App\Support\ValueStores\UpdatedRepositoriesValueStore;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Spatie\Valuestore\Valuestore;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GithubController
{
    public function __invoke(Request $request)
    {
        $this->ensureValidRequest($request);

        $payload = json_decode($request->getContent(), true);
        $updatedRepository = $payload['repository']['full_name'] ?? null;

        if ($updatedRepository === null) {
            return;
        }

        UpdatedRepositoriesValueStore::make()->store($updatedRepository['name']);
    }

    protected function ensureValidRequest(Request $request): void
    {
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

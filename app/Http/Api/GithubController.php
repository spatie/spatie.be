<?php

namespace App\Http\Api;

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
        $updatedRepository = $payload['repository']['full_name'];

        $valueStore = Valuestore::make('storage/value_store.json');
        $repositories = $valueStore->get('updated_repositories');

        $repositories[$updatedRepository] = true;

        $valueStore->put('updated_repositories', $repositories);
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

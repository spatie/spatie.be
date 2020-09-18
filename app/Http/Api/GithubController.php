<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GithubController
{
    public function __invoke(Request $request)
    {
        $this->validate($request);

        $payload = json_decode($request->getContent(), true);

        $updatedRepository = $payload['repository']['full_name'];

        $redis = Redis::connection();
        $repositories = $redis->client()->get('repositories:updated');

        $repositories[$updatedRepository] = true;

        $redis->client()->set('repositories:updated', $repositories);
    }

    private function validate(Request $request): void
    {
        $signature = $request->headers->get('X-Hub-Signature');

        if ($signature === null) {
            throw new BadRequestHttpException('Header is not set');
        }

        $signatureParts = explode('=', $signature);

        if (count($signatureParts) !== 2) {
            throw new BadRequestHttpException('signature has an invalid format');
        }

        $knownSignature = hash_hmac('sha1', $request->getContent(), config('services.github.webhook_secret'));

        if (! hash_equals($knownSignature, $signatureParts[1])) {
            throw new UnauthorizedException('Could not verify the request signature ' . $signatureParts[1]);
        }
    }
}

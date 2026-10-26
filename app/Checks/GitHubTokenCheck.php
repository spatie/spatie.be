<?php

namespace App\Checks;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class GitHubTokenCheck extends Check
{
    protected string $tokenConfigKey = 'services.github.token';

    public function tokenConfigKey(string $tokenConfigKey): self
    {
        $this->tokenConfigKey = $tokenConfigKey;

        return $this;
    }

    public function run(): Result
    {
        $result = Result::make()->meta(['config_key' => $this->tokenConfigKey]);
        $token = config($this->tokenConfigKey);

        if (blank($token)) {
            return $result
                ->failed("{$this->getLabel()} is not configured.")
                ->shortSummary('Missing token');
        }

        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/vnd.github+json',
                    'User-Agent' => 'spatie.be health check',
                ])
                ->connectTimeout(2)
                ->timeout(5)
                ->withoutRedirecting()
                ->get('https://api.github.com/user');
        } catch (ConnectionException) {
            return $result
                ->warning('GitHub could not be reached to validate the token.')
                ->shortSummary('GitHub unreachable');
        }

        if ($response->unauthorized()) {
            return $result
                ->failed("GitHub rejected {$this->getLabel()} (HTTP 401). Replace the expired, revoked, or invalid token.")
                ->shortSummary('Invalid token');
        }

        $hasRateLimitIndicators = $response->header('X-RateLimit-Remaining') === '0'
            || $response->header('Retry-After')
            || Str::contains((string) $response->json('message'), 'secondary rate limit', ignoreCase: true);

        if ($response->tooManyRequests() || ($response->forbidden() && $hasRateLimitIndicators)) {
            return $result
                ->warning('GitHub rate limiting prevented token validation. Try again after the rate limit resets.')
                ->shortSummary('GitHub rate limited');
        }

        if ($response->serverError()) {
            return $result
                ->warning("GitHub returned HTTP {$response->status()}; token validity could not be checked.")
                ->shortSummary('GitHub unavailable');
        }

        if (! $response->ok()) {
            return $result
                ->failed("GitHub returned HTTP {$response->status()} while validating {$this->getLabel()}.")
                ->shortSummary('Token validation failed');
        }

        if (! $response->json('id')) {
            return $result
                ->failed('GitHub did not return an authenticated user while validating the token.')
                ->shortSummary('Unexpected GitHub response');
        }

        return $result->ok()->shortSummary('Authenticated');
    }
}

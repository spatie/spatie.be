<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Temporary: identifies who sends POST requests to the homepage. Remove once the sender is known.
 */
class LogUnknownPostRequestController
{
    protected string $secretPattern = '/token|secret|password|key|signature|auth/i';

    public function __invoke(Request $request): never
    {
        Log::info('Unknown POST / request', [
            'ip' => $request->ip(),
            'headers' => $this->headers($request),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'body' => Str::limit($this->body($request), 1000),
        ]);

        abort(405);
    }

    /** @return array<string, string> */
    protected function headers(Request $request): array
    {
        $headers = Arr::except($request->headers->all(), ['cookie', 'authorization', 'proxy-authorization']);

        return collect($headers)
            ->map(fn (array $values, string $name) => preg_match($this->secretPattern, $name)
                ? '[redacted]'
                : implode(', ', $values))
            ->all();
    }

    protected function body(Request $request): string
    {
        $content = $request->getContent();

        $data = $request->isJson()
            ? json_decode($content, true)
            : $request->request->all();

        if (! is_array($data) || $data === []) {
            return preg_replace(
                '/((?:token|secret|password|key|signature)[^=:"]*["\']?\s*[=:]\s*["\']?)[^"\'&,\s}]+/i',
                '$1[redacted]',
                $content,
            );
        }

        return json_encode($this->redact($data), JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array<array-key, mixed>
     */
    protected function redact(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($key) && preg_match('/token|secret|password|key|signature/i', $key)) {
                $data[$key] = '[redacted]';

                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->redact($value);
            }
        }

        return $data;
    }
}

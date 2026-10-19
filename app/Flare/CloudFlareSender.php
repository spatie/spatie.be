<?php

namespace App\Flare;

use Closure;
use Spatie\FlareClient\Enums\FlareEntityType;
use Spatie\FlareClient\Senders\DaemonSender;
use Spatie\FlareClient\Senders\Sender;
use Spatie\FlareClient\Senders\Support\Response;
use Spatie\LaravelFlare\Senders\LaravelHttpSender;

class CloudFlareSender implements Sender
{
    protected Sender $sender;

    /** @param array<string, mixed> $config */
    public function __construct(array $config = [])
    {
        if (PHP_SAPI === 'cli') {
            if (in_array($_SERVER['argv'][1] ?? null, ['queue:work', 'queue:listen', 'horizon', 'horizon:work'], true)) {
                $this->sender = new LaravelHttpSender(['timeout' => 10]);

                return;
            }
        }

        $this->sender = new DaemonSender($config);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  Closure(Response): void  $callback
     */
    public function post(
        string $endpoint,
        string $apiToken,
        array $payload,
        FlareEntityType $type,
        bool $test,
        Closure $callback,
    ): void {
        $this->sender->post($endpoint, $apiToken, $payload, $type, $test, $callback);
    }
}

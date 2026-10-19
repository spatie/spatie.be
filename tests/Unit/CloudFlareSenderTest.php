<?php

namespace Tests\Unit;

use App\Flare\CloudFlareSender;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Spatie\FlareClient\Senders\DaemonSender;
use Spatie\LaravelFlare\Senders\LaravelHttpSender;

class CloudFlareSenderTest extends TestCase
{
    #[DataProvider('queueCommands')]
    public function test_queue_workers_send_directly(string $command): void
    {
        $arguments = $_SERVER['argv'];

        try {
            $_SERVER['argv'] = ['artisan', $command];
            $sender = new CloudFlareSender(['daemon_url' => 'http://127.0.0.1:8787']);

            $this->assertInstanceOf(LaravelHttpSender::class, (new ReflectionProperty($sender, 'sender'))->getValue($sender));
        } finally {
            $_SERVER['argv'] = $arguments;
        }
    }

    public function test_other_processes_use_the_local_daemon(): void
    {
        $arguments = $_SERVER['argv'];

        try {
            $_SERVER['argv'] = ['artisan', 'schedule:run'];
            $sender = new CloudFlareSender(['daemon_url' => 'http://127.0.0.1:8787']);

            $this->assertInstanceOf(DaemonSender::class, (new ReflectionProperty($sender, 'sender'))->getValue($sender));
        } finally {
            $_SERVER['argv'] = $arguments;
        }
    }

    /** @return array<string, array{string}> */
    public static function queueCommands(): array
    {
        return [
            'queue worker' => ['queue:work'],
            'queue listener' => ['queue:listen'],
            'horizon' => ['horizon'],
            'horizon worker' => ['horizon:work'],
        ];
    }
}

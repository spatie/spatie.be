<?php

use Illuminate\Support\Facades\Log;

it('logs unknown post requests to the homepage and still responds with 405', function () {
    Log::spy();

    $this
        ->withHeaders([
            'User-Agent' => 'GuzzleHttp/7',
            'X-Webhook-Signature' => 'abc123',
            'Cookie' => 'session=secret',
        ])
        ->postJson('/', ['event' => 'ping', 'api_token' => 'super-secret'])
        ->assertStatus(405);

    Log::shouldHaveReceived('info')
        ->withArgs(function (string $message, array $context) {
            expect($message)->toBe('Unknown POST / request');
            expect($context['headers']['user-agent'])->toBe('GuzzleHttp/7');
            expect($context['headers']['x-webhook-signature'])->toBe('[redacted]');
            expect($context['headers'])->not->toHaveKey('cookie');
            expect($context['content_type'])->toBe('application/json');
            expect($context['body'])->toBe('{"event":"ping","api_token":"[redacted]"}');

            return true;
        })
        ->once();
});

it('redacts secrets in non json bodies', function () {
    Log::spy();

    $this
        ->call('POST', '/', [], [], [], ['CONTENT_TYPE' => 'text/plain'], 'event=ping&secret=hunter2')
        ->assertStatus(405);

    Log::shouldHaveReceived('info')
        ->withArgs(fn (string $message, array $context) => $context['body'] === 'event=ping&secret=[redacted]')
        ->once();
});

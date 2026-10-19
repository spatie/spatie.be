<?php

use App\Support\ValueStores\UpdatedRepositoriesValueStore;

beforeEach(function () {
    config()->set('docs.cache_store', 'array');
    config()->set('services.github.webhook_secret', 'webhook-secret');
});

it('remembers the repositories that were updated', function () {
    foreach (['spatie/laravel-backup', 'spatie/laravel-backup', 'spatie/laravel-medialibrary'] as $repositoryName) {
        $payload = json_encode(['repository' => ['full_name' => $repositoryName]]);

        $this
            ->call('POST', '/api/webhooks/github', server: [
                'HTTP_X_HUB_SIGNATURE' => 'sha1=' . hash_hmac('sha1', $payload, 'webhook-secret'),
                'CONTENT_TYPE' => 'application/json',
            ], content: $payload)
            ->assertSuccessful();
    }

    expect(UpdatedRepositoriesValueStore::make()->getNames())
        ->toBe(['spatie/laravel-backup', 'spatie/laravel-medialibrary']);
});

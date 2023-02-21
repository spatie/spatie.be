<?php

use App\Actions\SubscribeUserToNewsletterAction;
use App\Models\User;
use Illuminate\Support\Facades\Http;

it('subscribes the user to the spatie email list', function () {
    Http::preventStrayRequests();
    Http::fake();

    $action = resolve(SubscribeUserToNewsletterAction::class);
    $user = User::factory()->create();

    $action->execute($user);

    Http::assertSentCount(2); // 1 for subscribe 1 for tags
});

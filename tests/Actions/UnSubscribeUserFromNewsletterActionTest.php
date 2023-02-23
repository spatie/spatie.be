<?php

use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Models\User;
use Illuminate\Support\Facades\Http;

it('unsubscribes the user to the spatie email list', function () {
    Http::preventStrayRequests();

    $user = User::factory()->create();
    $email = urlencode($user->email);

    Http::fake([
        "https://spatie.mailcoach.app/api/email-lists/4af46b59-3784-41a5-9272-6da31afa3a02/subscribers?filter%5Bemail%5D={$email}" => Http::response(['data' => [['uuid' => '1234', 'email' => $user->email, 'subscribed_at' => now(), 'unsubscribed_at' => null]]]),
        "https://spatie.mailcoach.app/api/subscribers/1234/unsubscribe" => Http::response(),
        "https://spatie.mailcoach.app/api/subscribers/1234" => Http::response(),
    ]);

    $action = resolve(UnsubscribeUserFromNewsletterAction::class);

    $action->execute($user);

    Http::assertSentCount(2); // 1 for retrieving and 1 for unsubscribing
});

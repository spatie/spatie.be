<?php

use App\Domain\Shop\Actions\AddPurchasedTagsToEmailListSubscriberAction;
use App\Domain\Shop\Models\Purchase;
use App\Services\Mailcoach\MailcoachApi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('will add tags for the purchasable on the mailing list', function () {
    $purchase = Purchase::factory()->create();
    $email = urlencode($purchase->user->email);

    Http::fake([
        "https://spatie.mailcoach.app/api/email-lists/4af46b59-3784-41a5-9272-6da31afa3a02/subscribers?filter%5Bemail%5D={$email}" => Http::response(['data' => [['uuid' => '1234', 'email' => urldecode($email), 'subscribed_at' => now(), 'unsubscribed_at' => null]]]),
        "https://spatie.mailcoach.app/api/subscribers/1234" => Http::response(),
    ]);

    $this->partialMock(MailcoachApi::class)
        ->shouldReceive('addTags')
        ->withSomeOfArgs([
            "purchased-product-" . Str::slug($purchase->purchasable->product->title),
            "purchased-purchasable-" . Str::slug($purchase->purchasable->product->title) . '-' . Str::slug($purchase->purchasable->title),
        ])
        ->passthru()
        ->once();

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);

    Http::assertSentCount(2); // 1 to retreive, 1 for tags
});

it('will add tags for a bundle purchase', function () {
    $purchase = Purchase::factory()->forBundle()->create();
    $email = urlencode($purchase->user->email);

    $purchasable1 = $purchase->bundle->purchasables->first();
    $purchasable2 = $purchase->bundle->purchasables->skip(1)->first();

    Http::fake([
        "https://spatie.mailcoach.app/api/email-lists/4af46b59-3784-41a5-9272-6da31afa3a02/subscribers?filter%5Bemail%5D={$email}" => Http::response(['data' => [['uuid' => '1234', 'email' => urldecode($email), 'subscribed_at' => now(), 'unsubscribed_at' => null]]]),
        "https://spatie.mailcoach.app/api/subscribers/1234" => Http::response(),
    ]);

    $this->partialMock(MailcoachApi::class)
        ->shouldReceive('addTags')
        ->withSomeOfArgs([
            "purchased-product-" . Str::slug($purchasable1->product->title),
            "purchased-purchasable-" . Str::slug($purchasable1->product->title) . '-' . Str::slug($purchasable1->title),
            "purchased-product-" . Str::slug($purchasable2->product->title),
            "purchased-purchasable-" . Str::slug($purchasable2->product->title) . '-' . Str::slug($purchasable2->title),
        ])
        ->passthru()
        ->once();

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);

    Http::assertSentCount(2); // 1 to retreive, 1 for tags
});

it('doesnt crash if the user has no email', function () {
    $purchase = Purchase::factory()->create();
    $purchase->user->update(['email' => '']);

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);

    Http::assertSentCount(0);
});

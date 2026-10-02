<?php

use App\Domain\Shop\Actions\AddPurchasedTagsToEmailListSubscriberAction;
use App\Domain\Shop\Models\Purchase;
use App\Services\Mailcoach\MailcoachApi;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Exceptions;
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

it('does not report an error when mailcoach rejects the subscriber', function () {
    Exceptions::fake();

    $purchase = Purchase::factory()->create();

    Http::fake([
        'https://spatie.mailcoach.app/api/email-lists/*' => fn (Request $request) => $request->method() === 'GET'
            ? Http::response(['data' => []])
            : Http::response(['message' => 'The email has already been taken.', 'errors' => ['email' => ['The email has already been taken.']]], 422),
    ]);

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);

    Http::assertSentCount(2);
    Exceptions::assertNothingReported();
});

it('throws when mailcoach fails unexpectedly', function (int $status) {
    $purchase = Purchase::factory()->create();

    Http::fake([
        'https://spatie.mailcoach.app/api/email-lists/*' => fn (Request $request) => $request->method() === 'GET'
            ? Http::response(['data' => []])
            : Http::response(['message' => 'Something went wrong.'], $status),
    ]);

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);
})->with([
    'unauthenticated' => 401,
    'server error' => 500,
])->throws(RequestException::class);

it('asks the mailcoach api for json responses', function () {
    $purchase = Purchase::factory()->create();

    Http::fake([
        'https://spatie.mailcoach.app/api/email-lists/*' => Http::response(['data' => [['uuid' => '1234', 'email' => $purchase->user->email, 'subscribed_at' => now(), 'unsubscribed_at' => null]]]),
        'https://spatie.mailcoach.app/api/subscribers/1234' => Http::response(),
    ]);

    app(AddPurchasedTagsToEmailListSubscriberAction::class)->execute($purchase);

    Http::assertSent(fn (Request $request) => $request->hasHeader('Accept', 'application/json'));
    Http::assertNotSent(fn (Request $request) => ! $request->hasHeader('Accept', 'application/json'));
});

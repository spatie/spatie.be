<?php

use App\Domain\Shop\Actions\AddPurchasedTagsToEmailListSubscriberAction;
use App\Domain\Shop\Models\Purchase;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

uses(TestCase::class);

it('will add tags for the purchasable on the mailing list', function () {
    /** @var EmailList $emailList */
    $emailList = EmailList::create(['name' => 'Spatie']);

    $purchase = Purchase::factory()->create();

    (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

    expect($emailList->isSubscribed($purchase->user->email))->toBeTrue();

    $subscriber = Subscriber::findForEmail($purchase->user->email, $emailList);

    $tagNames = $subscriber->tags->pluck('name')->toArray();

    $this->assertEquals([
        "purchased-product-" . Str::slug($purchase->purchasable->product->title),
        "purchased-purchasable-" .Str::slug($purchase->purchasable->product->title) . '-' . Str::slug($purchase->purchasable->title),
    ], $tagNames);
});

it('will add tags for a bundle purchase', function () {
    /** @var EmailList $emailList */
    $emailList = EmailList::create(['name' => 'Spatie']);

    $purchase = Purchase::factory()->forBundle()->create();

    (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

    expect($emailList->isSubscribed($purchase->user->email))->toBeTrue();

    $subscriber = Subscriber::findForEmail($purchase->user->email, $emailList);

    $tagNames = $subscriber->tags->pluck('name')->toArray();

    $purchasable1 = $purchase->bundle->purchasables->first();
    $purchasable2 = $purchase->bundle->purchasables->skip(1)->first();

    $this->assertEqualsCanonicalizing([
        "purchased-product-" . Str::slug($purchasable1->product->title),
        "purchased-product-" . Str::slug($purchasable2->product->title),
        "purchased-purchasable-" .Str::slug($purchasable1->product->title) . '-' . Str::slug($purchasable1->title),
        "purchased-purchasable-" .Str::slug($purchasable2->product->title) . '-' . Str::slug($purchasable2->title),
    ], $tagNames);
});

test('the add purchased tags to email list subscriber action is idempotent', function () {
    /** @var EmailList $emailList */
    $emailList = EmailList::create(['name' => 'Spatie']);

    $purchase = Purchase::factory()->create();

    (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);
    (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

    expect($emailList->subscribers)->toHaveCount(1);

    expect($emailList->subscribers->first()->tags)->toHaveCount(2);
});

it('doesnt crash if the user has no email', function () {
    $purchase = Purchase::factory()->create();
    $purchase->user->update(['email' => '']);

    (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

    $this->expectNotToPerformAssertions();
});

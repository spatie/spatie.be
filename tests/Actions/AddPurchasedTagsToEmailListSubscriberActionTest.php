<?php

namespace Tests\Actions;

use App\Actions\AddPurchasedTagsToEmailListSubscriberAction;
use App\Models\Purchase;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

class AddPurchasedTagsToEmailListSubscriberActionTest extends TestCase
{
    /** @test */
    public function it_will_add_tags_for_the_purchasable_on_the_mailing_list()
    {
        /** @var EmailList $emailList */
        $emailList = EmailList::create(['name' => 'Spatie']);

        $purchase = Purchase::factory()->create();

        (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

        $this->assertTrue($emailList->isSubscribed($purchase->user->email));

        $subscriber = Subscriber::findForEmail($purchase->user->email, $emailList);

        $tagNames = $subscriber->tags->pluck('name')->toArray();

        $this->assertEquals([
            "purchased-product-" . Str::slug($purchase->purchasable->product->title),
            "purchased-purchasable-" .Str::slug($purchase->purchasable->product->title) . '-' . Str::slug($purchase->purchasable->title),
        ], $tagNames);
    }

    /** @test */
    public function the_AddPurchasedTagsToEmailListSubscriberAction_is_idempotent()
    {
        /** @var EmailList $emailList */
        $emailList = EmailList::create(['name' => 'Spatie']);

        $purchase = Purchase::factory()->create();

        (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);
        (new AddPurchasedTagsToEmailListSubscriberAction())->execute($purchase);

        $this->assertCount(1, $emailList->subscribers);

        $this->assertCount(2, $emailList->subscribers->first()->tags);
    }
}

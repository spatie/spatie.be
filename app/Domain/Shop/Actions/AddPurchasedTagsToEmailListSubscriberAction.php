<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Services\Mailcoach\MailcoachApi;
use App\Services\Mailcoach\Subscriber;
use Illuminate\Support\Str;

class AddPurchasedTagsToEmailListSubscriberAction
{
    public function __construct(private MailcoachApi $mailcoachApi)
    {
    }

    public function execute(Purchase $purchase)
    {
        if (empty($purchase->user->email)) {
            return;
        }

        $subscriber = $this->findOrCreateSubscriber($purchase->user->email);

        if (! $subscriber) {
            report(new \Exception("Could not subscribe subscriber"));
            return;
        }

        $tagNames = $this->getTagNames($purchase);

        $this->mailcoachApi->addTags($subscriber, $tagNames);
    }

    protected function findOrCreateSubscriber(string $email): ?Subscriber
    {
        if ($subscriber = $this->mailcoachApi->getSubscriber($email)) {
            return $subscriber;
        }

        return $this->mailcoachApi->subscribe($email, skipConfirmation: true);
    }

    protected function getTagNames(Purchase $purchase): array
    {
        return $purchase->getPurchasables()->flatMap(function (Purchasable $purchasable) {
            $productName = $purchasable->product->title;
            $purchasableName = $purchasable->title;

            return [
                "purchased-product-" . Str::slug($productName),
                "purchased-purchasable-" . Str::slug($productName) .  '-' . Str::slug($purchasableName),
            ];
        })->toArray();
    }
}

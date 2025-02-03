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

        $listUuid = match ($purchase->purchasable_id) {
            3, 4, 5, 6, 7 => 'b590dc69-939a-47e3-ba48-ba588c167aa6', // Mailcoach
            default => null
        };

        $subscriber = $this->findOrCreateSubscriber($purchase->user->email, $listUuid);

        if (! $subscriber) {
            report(new \Exception("Could not subscribe subscriber"));

            return;
        }

        $tagNames = $this->getTagNames($purchase);

        $this->mailcoachApi->addTags($subscriber, $tagNames);
    }

    protected function findOrCreateSubscriber(string $email, ?string $listUuid = null): ?Subscriber
    {
        if ($subscriber = $this->mailcoachApi->getSubscriber($email, $listUuid)) {
            return $subscriber;
        }

        return $this->mailcoachApi->subscribe($email, $listUuid, skipConfirmation: true);
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

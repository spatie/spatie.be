<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Services\Mailcoach\MailcoachApi;
use App\Services\Mailcoach\Subscriber;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AddPurchasedTagsToEmailListSubscriberAction
{
    public function __construct(private MailcoachApi $mailcoachApi)
    {
    }

    public function execute(Purchase $purchase): void
    {
        if (empty($purchase->user->email)) {
            return;
        }

        $listUuid = match ($purchase->purchasable_id) {
            3, 4, 5, 6, 7 => 'b590dc69-939a-47e3-ba48-ba588c167aa6', // Mailcoach
            default => null
        };

        try {
            $subscriber = $this->findOrCreateSubscriber($purchase->user->email, $listUuid);
        } catch (RequestException $exception) {
            if (! $exception->response->unprocessableEntity()) {
                throw $exception;
            }

            Log::info("Mailcoach did not accept the subscriber for purchase `{$purchase->id}`: {$exception->response->json('message')}");

            return;
        }

        if (! $subscriber) {
            report(new Exception("Could not subscribe subscriber for purchase `{$purchase->id}`"));

            return;
        }

        $tagNames = $this->getTagNames($purchase);

        $this->mailcoachApi->addTags($subscriber, $tagNames);
    }

    protected function findOrCreateSubscriber(string $email, ?string $listUuid = null): ?Subscriber
    {
        if ($subscriber = $this->mailcoachApi->findSubscriber($email, $listUuid)) {
            return $subscriber;
        }

        return $this->mailcoachApi->createSubscriber($email, $listUuid, skipConfirmation: true);
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

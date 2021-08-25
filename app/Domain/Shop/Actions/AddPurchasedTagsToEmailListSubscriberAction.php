<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Spatie\Mailcoach\Domain\Audience\Exceptions\CouldNotSubscribe;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;

class AddPurchasedTagsToEmailListSubscriberAction
{
    public function execute(Purchase $purchase)
    {
        if (empty($purchase->user->email)) {
            return;
        }

        $emailList = EmailList::firstWhere('name', 'Spatie');

        try {
            $subscriber = $this->findOrCreateSubscriber($purchase->user->email, $emailList);
        } catch (CouldNotSubscribe $exception) {
            report($exception);

            return;
        }

        $tagNames = $this->getTagNames($purchase);

        $subscriber->addTags($tagNames);
    }

    protected function findOrCreateSubscriber(string $email, EmailList $emailList): Subscriber
    {
        if ($subscriber = Subscriber::findForEmail($email, $emailList)) {
            return $subscriber;
        }

        $subscriber = Subscriber::createWithEmail($email)
            ->skipConfirmation()
            ->doNotSendWelcomeMail()
            ->subscribeTo($emailList);

        return Subscriber::find($subscriber->id);
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

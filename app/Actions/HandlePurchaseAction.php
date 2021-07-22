<?php

namespace App\Actions;

use App\Mail\PurchaseConfirmationMail;
use App\Models\Bundle;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\Referrer;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use App\Support\Paddle\PaddlePayload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Laravel\Paddle\Receipt;

class HandlePurchaseAction
{
    protected HandlePurchaseLicensingAction $handlePurchaseLicensingAction;
    protected RestoreRepositoryAccessAction $restoreRepositoryAccessAction;
    protected StartOrExtendNextPurchaseDiscountPeriodAction $startOrExtendExtraDiscountPeriodAction;
    protected AddPurchasedTagsToEmailListSubscriberAction $addPurchasedTagsToEmailListSubscriberAction;
    protected AttributePurchaseToReferrer $attributePurchaseToReferrerAction;
    protected GitHubApi $gitHubApi;

    public function __construct(
        HandlePurchaseLicensingAction $handlePurchaseLicensingAction,
        RestoreRepositoryAccessAction $restoreRepositoryAccessAction,
        StartOrExtendNextPurchaseDiscountPeriodAction $startOrExtendExtraDiscountPeriodAction,
        AddPurchasedTagsToEmailListSubscriberAction $addPurchasedTagsToEmailListSubscriberAction,
        AttributePurchaseToReferrer $attributePurchaseToReferrerAction,
        GitHubApi $gitHubApi
    ) {
        $this->handlePurchaseLicensingAction = $handlePurchaseLicensingAction;
        $this->restoreRepositoryAccessAction = $restoreRepositoryAccessAction;
        $this->startOrExtendExtraDiscountPeriodAction = $startOrExtendExtraDiscountPeriodAction;
        $this->addPurchasedTagsToEmailListSubscriberAction = $addPurchasedTagsToEmailListSubscriberAction;
        $this->attributePurchaseToReferrerAction = $attributePurchaseToReferrerAction;
        $this->gitHubApi = $gitHubApi;
    }

    public function execute(
        User $user,
        Bundle|Purchasable $purchasable,
        PaddlePayload $paddlePayload,
        ?Referrer $referrer = null
    ): Purchase {
        $purchase = $this->createPurchase($user, $purchasable, $paddlePayload);

        $purchase = $this->handlePurchaseLicensingAction->execute($purchase);

        $purchasables = $purchase->getPurchasables();
        foreach ($purchasables as $purchasable) {
            if ($purchasable->repository_access && $user->github_username) {
                $this->restoreRepositoryAccessAction->execute($user);
            }
        }

        $this->startOrExtendExtraDiscountPeriodAction->execute($user);

        $this->addPurchasedTagsToEmailListSubscriberAction->execute($purchase);

        if ($referrer) {
            $this->attributePurchaseToReferrerAction->execute($purchase, $referrer);
        }

        if ($purchase->unlocksRayLicense()) {
            $this->createOrExtendRayLicense($user, $purchase);
        }

        if ($user->email) {
            foreach ($purchasables as $purchasable) {
                Mail::to($user->email)->queue(new PurchaseConfirmationMail($purchase, $purchasable));
            }
        }

        return $purchase->refresh();
    }

    protected function createPurchase(
        User $user,
        Bundle|Purchasable $purchasable,
        PaddlePayload $paddlePayload
    ): Purchase {
        $receipt = Receipt::where('order_id', $paddlePayload->order_id)->first();

        $data = [
            'user_id' => $user->id,
            'quantity' => $paddlePayload->quantity(),
            'receipt_id' => $receipt->id,
            'paddle_webhook_payload' => $paddlePayload->toArray(),
            'paddle_fee' => $paddlePayload->balance_fee,
            'earnings' => $paddlePayload->balance_earnings,
            'passthrough' => $paddlePayload->passthrough(),
        ];

        if ($purchasable instanceof Bundle) {
            $data['bundle_id'] = $purchasable->id;
        } else {
            $data['purchasable_id'] = $purchasable->id;
        }

        return Purchase::create($data);
    }

    public function createOrExtendRayLicense(User $user, Purchase $purchase)
    {
        /** @var Purchasable|null $rayPurchasable */
        $rayPurchasable = Purchasable::query()
            ->whereHas('product', function (Builder $query) {
                $query->where('slug', 'ray');
            })
            ->where('type', 'standard')
            ->first();

        /** @var License|null $existingLicense */
        $existingLicense = $user->licenses()->where('purchasable_id', $rayPurchasable->id)->first();

        if ($existingLicense) {
            $existingLicense->renew();

            return;
        }

        app(CreateLicenseAction::class)->execute($user, $purchase, $rayPurchasable);
    }
}

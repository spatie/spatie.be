<?php

namespace App\Domain\Shop\Actions;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Domain\Shop\Models\Referrer;
use App\Mail\PurchaseConfirmationMail;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use App\Support\Paddle\PaddlePayload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

        $this->createAssignments($purchase, $paddlePayload);

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

        /** @var PurchaseAssignment $assignment */
        $assignment = PurchaseAssignment::query()
            ->firstOrCreate([
                'user_id' => $user->id,
                'purchase_id' => $purchase->id,
                'purchasable_id' => $rayPurchasable->id,
            ]);

        app(CreateLicenseAction::class)->execute($assignment);
    }

    private function createAssignments(Purchase $purchase, PaddlePayload $paddlePayload): void
    {
        $emails = $paddlePayload->passthrough()['emails'] ?? [$purchase->user->email];

        foreach ($emails as $email) {
            // TODO: CreateUserAction with welcome mail
            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'name' => $email,
                'password' => bcrypt(Str::random(20)),
            ]);

            foreach ($purchase->getPurchasables() as $purchasable) {
                PurchaseAssignment::create([
                    'user_id' => $user->id,
                    'purchase_id' => $purchase->id,
                    'purchasable_id' => $purchasable->id,
                ]);
            }
        }
    }
}

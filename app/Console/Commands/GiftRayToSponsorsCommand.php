<?php

namespace App\Console\Commands;

use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Illuminate\Console\Command;

class GiftRayToSponsorsCommand extends Command
{
    protected $signature = 'gift-ray-to-sponsors';

    public function handle()
    {
        $this->info('Start handing out Ray to sponsors...');

        $rayPurchasable = Purchasable::find(15);

        User::query()
            ->cursor()
            ->filter(fn (User $user) => $user->isSponsoring())
            ->filter(fn (User $user) => is_null($user->sponsor_gift_given_at))
            ->each(function (User $user) use ($rayPurchasable) {
                $this->comment("Handing Ray to user {$user->id} ($user->email)");

                /** @var \App\Domain\Shop\Models\PurchaseAssignment $existingAssignment */
                $existingAssignment = $user->assignments()->where('purchasable_id', $rayPurchasable->id)->first();

                $existingAssignment
                    ? $this->renewExistingLicense($existingAssignment)
                    : $this->createNewLicense($user, $rayPurchasable);

                $user->update(['sponsor_gift_given_at' => now()]);
            });

        $this->info('All done!');
    }

    protected function renewExistingLicense(PurchaseAssignment $assignment): void
    {
        $assignment->licenses()->first()->renew();

        $this->comment('Renewed existing Ray license.');
    }

    protected function createNewLicense(User $user, Purchasable $purchasable): void
    {
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'purchasable_id' => $purchasable->id,
            'quantity' => 1,
            'receipt_id' => null,
            'paddle_webhook_payload' => null,
            'paddle_fee' => 0,
            'earnings' => 0,
            'passthrough' => null,
        ]);

        $purchaseAssignment = PurchaseAssignment::create([
            'user_id' => $user->id,
            'purchase_id' => $purchase->id,
            'purchasable_id' => $purchasable->id,
        ]);

        app(CreateLicenseAction::class)->execute($purchaseAssignment);

        $this->comment('New license created.');
    }
}

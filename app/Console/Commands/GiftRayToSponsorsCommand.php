<?php

namespace App\Console\Commands;

use App\Actions\CreateLicenseAction;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
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
            ->filter(fn(User $user) => $user->isSponsoring())
            ->filter(fn(User $user) => is_null($user->sponsor_gift_given_at))
            ->each(function (User $user) use ($rayPurchasable) {
                $this->comment("Handing Ray to user {$user->id} ($user->email)");

                /** @var \App\Models\License|null $existingLicense */
                $existingLicense = $user->licenses()->where('purchasable_id', $rayPurchasable->id)->first();

                $existingLicense
                    ? $this->renewExistingLicense($existingLicense)
                    : $this->createNewLicense($user, $rayPurchasable);

                $user->update(['sponsor_gift_given_at' => now()]);
            });

        $this->info('All done!');
    }

    protected function renewExistingLicense(License $license): void
    {
        $license->renew();

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

        app(CreateLicenseAction::class)->execute($user, $purchase, $purchasable);

        $this->comment('New license created.');
    }
}

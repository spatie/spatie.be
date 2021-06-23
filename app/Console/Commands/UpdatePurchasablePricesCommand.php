<?php

namespace App\Console\Commands;

use App\Models\ConversionRate;
use App\Models\Purchasable;
use App\Support\Paddle\EuCountries;
use App\Support\Paddle\PaddleCountries;
use App\Support\Paddle\PaddleCurrencies;
use Illuminate\Console\Command;

class UpdatePurchasablePricesCommand extends Command
{
    protected $signature = 'update-purchasable-prices';

    protected $description = 'Update purchasable prices';

    public function handle()
    {
        $this->info('Start updating purchasable prices...');

        Purchasable::each(function (Purchasable $purchasable) {
            $this->info("Updating prices of purchasable id `{$purchasable->id}`...");

            PaddleCountries::get()->each(function (array $countryAttributes) use ($purchasable) {
                $price = $purchasable->prices()->firstOrCreate(
                    ['country_code' => $countryAttributes['code']],
                    [
                        'currency_code' => 'USD',
                        'currency_symbol' => '$',
                        'amount' => $purchasable->price_in_usd_cents,
                    ],
                );

                if ($price->overridden) {
                    return;
                }

                if (EuCountries::contains($countryAttributes['code'])) {
                    $conversionRate = ConversionRate::forCountryCode('BE');
ray($countryAttributes['code']);
ray($conversionRate);
ray($purchasable);
                    $price->update([
                        'currency_code' => 'EUR',
                        'currency_symbol' => '€',
                        'amount' => $conversionRate->getAmountForUsd($purchasable->price_in_usd_cents),
                    ]);
                }

                $conversionRate = ConversionRate::forCountryCode($countryAttributes['code']);

                if (! $conversionRate) {
                    $price->update([
                        'currency_code' => 'USD',
                        'currency_symbol' => '$',
                        'amount' => $purchasable->price_in_usd_cents,
                    ]);

                    return;
                }

                if (PaddleCurrencies::contains($conversionRate->currency_code)) {
                    $amount = $conversionRate->getAmountForUsd($purchasable->price_in_usd_cents);

                    $price->update([
                        'currency_code' => $conversionRate->currency_code,
                        'currency_symbol' => $conversionRate->currency_symbol,

                        'amount' => $amount,
                    ]);

                    return;
                }

                $price->update([
                    'currency_code' => 'USD',
                    'currency_symbol' => '$',
                    'amount' => $conversionRate->getPPPInUsd($purchasable->price_in_usd_cents),
                ]);
            });
        });


        $this->info('All done!');
    }
}

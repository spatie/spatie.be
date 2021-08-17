<?php

namespace App\Domain\Shop\Commands;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\ConversionRate;
use App\Support\Paddle\EuCountries;
use App\Support\Paddle\PaddleCountries;
use App\Support\Paddle\PaddleCurrencies;
use Illuminate\Console\Command;

class UpdateBundlePricesCommand extends Command
{
    protected $signature = 'update-bundle-prices';

    protected $description = 'Update bundle prices';

    public function handle()
    {
        $this->info('Start updating bundle prices...');

        Bundle::each(function (Bundle $bundle) {
            $this->info("Updating prices of bundle id `{$bundle->id}`...");

            PaddleCountries::get()->each(function (array $countryAttributes) use ($bundle) {
                $price = $bundle->prices()->firstOrCreate(
                    ['country_code' => $countryAttributes['code']],
                    [
                        'currency_code' => 'USD',
                        'currency_symbol' => '$',
                        'amount' => $bundle->price_in_usd_cents,
                    ],
                );

                if ($price->overridden) {
                    return;
                }

                if (EuCountries::contains($countryAttributes['code'])) {
                    $conversionRate = ConversionRate::forCountryCode('BE');
                    $price->update([
                        'currency_code' => 'EUR',
                        'currency_symbol' => '€',
                        'amount' => $conversionRate->getAmountForUsd($bundle->price_in_usd_cents),
                    ]);
                }

                $conversionRate = ConversionRate::forCountryCode($countryAttributes['code']);

                if (! $conversionRate) {
                    $price->update([
                        'currency_code' => 'USD',
                        'currency_symbol' => '$',
                        'amount' => $bundle->price_in_usd_cents,
                    ]);

                    return;
                }

                if (PaddleCurrencies::contains($conversionRate->currency_code)) {
                    $amount = $conversionRate->getAmountForUsd($bundle->price_in_usd_cents);

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
                    'amount' => $conversionRate->getPPPInUsd($bundle->price_in_usd_cents),
                ]);
            });
        });


        $this->info('All done!');
    }
}

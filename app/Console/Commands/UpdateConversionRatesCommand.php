<?php

namespace App\Console\Commands;

use App\Models\ConversionRate;
use App\Support\Paddle\PaddleCountries;
use App\Support\PPPApi\PPPApi;
use Illuminate\Console\Command;

class UpdateConversionRatesCommand extends Command
{
    protected $signature = 'update-conversion-rates';

    protected $description = 'Update conversion rates';

    public function handle()
    {
        $this->info('Start updating conversion rates...');

        PaddleCountries::get()->each(function (array $country) {
            $this->comment("Getting conversion rate for `{$country['code']}`...");

            $pppResponse = PPPApi::fetchForCountryCode($country['code']);

            if (! $pppResponse) {
                return;
            }

            ConversionRate::query()->updateOrCreate([
                'country_code' => $country['code'],
            ], [
                'currency_symbol' => $pppResponse->currencySymbol,
                'currency_code' => $pppResponse->currencyCode,
                'ppp_conversion_factor' => $pppResponse->conversionFactor,
                'exchange_rate' => $pppResponse->exchangeRate,
            ]);
        });

        $this->info('All done!');
    }
}

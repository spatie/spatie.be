<?php

namespace App\Filament\Resources\Shop\BundleResource\Actions;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\BundlePrice;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class UpdateBundlePriceForCurrencyAction
{
    public function make()
    {
        return Action::make('update_bundle_price')
            ->form([
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
            ])
            ->action(function (array $data, Bundle $record) {
                if (! isset($data['currency_code'])) {
                    Notification::make()
                        ->title('Currency code is required')
                        ->danger()
                        ->send();
                }

                if ($data['currency_code'] === 'USD') {
                    Notification::make()
                        ->title('You should define the USD price on the purchasable itself')
                        ->danger()
                        ->send();
                }

                if (! $data['amount_in_cents']) {
                    Notification::make()
                        ->title('You should define the USD price on the purchasable itself')
                        ->danger()
                        ->send();
                }

                if (! BundlePrice::where('currency_code', $data['currency_code'])->exists()) {
                    return Action::danger("No bundle price found for currency code {$data['currency_code']}");
                }

                $record
                    ->prices()
                    ->where('currency_code', $data['currency_code'])
                    ->update([
                        'amount' => $data['amount_in_cents'],
                        'overridden' => true,
                    ]);

                Notification::make()
                    ->title('Price updated!')
                    ->success()
                    ->send();
        });
    }
}

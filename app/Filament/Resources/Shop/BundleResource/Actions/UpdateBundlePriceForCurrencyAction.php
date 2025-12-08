<?php

namespace App\Filament\Resources\Shop\BundleResource\Actions;

use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\BundlePrice;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class UpdateBundlePriceForCurrencyAction
{
    public static function make()
    {
        return Action::make('update_bundle_price')
            ->icon('heroicon-o-currency-dollar')
            ->schema([
                TextInput::make('amount_in_cents')
                    ->label('Amount in cents')
                    ->required()
                    ->integer(),
                Select::make('currency_code')
                    ->options(BundlePrice::pluck('currency_code', 'currency_code')->unique()->sort()),
            ])
            ->action(function (array $data, Bundle $record): void {
                if ($data['currency_code'] === 'USD') {
                    Notification::make()
                        ->title('You should define the USD price on the purchasable itself')
                        ->danger()
                        ->send();

                    return;
                }

                if (! BundlePrice::where('currency_code', $data['currency_code'])->exists()) {
                    Notification::make()
                        ->title("No bundle price found for currency code {$data['currency_code']}")
                        ->danger()
                        ->send();

                    return;
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

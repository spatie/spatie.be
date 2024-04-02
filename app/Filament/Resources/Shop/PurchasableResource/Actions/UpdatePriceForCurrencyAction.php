<?php

namespace App\Filament\Resources\Shop\PurchasableResource\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchasablePrice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class UpdatePriceForCurrencyAction
{
    public static function make()
    {
        return Action::make('update_price_for_currency')
            ->icon('heroicon-o-currency-dollar')
            ->form([
                TextInput::make('amount_in_cents')
                    ->label('Amount in cents')
                    ->required()
                    ->integer(),
                Select::make('currency_code')
                    ->options(PurchasablePrice::pluck('currency_code', 'currency_code')->unique()->sort()),
            ])
            ->action(function (array $data, Purchasable $record): void {
                if (! isset($data['currency_code'])) {
                    Notification::make()
                        ->title('Currency code is required')
                        ->danger()
                        ->send();

                    return;
                }

                if ($data['currency_code'] === 'USD') {
                    Notification::make()
                        ->title('You should define the USD price on the purchasable itself')
                        ->danger()
                        ->send();

                    return;
                }

                if (! $data['amount_in_cents']) {
                    Notification::make()
                        ->title('You should define the USD price on the purchasable itself')
                        ->danger()
                        ->send();

                    return;
                }

                if (! PurchasablePrice::where('currency_code', $data['currency_code'])->exists()) {
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

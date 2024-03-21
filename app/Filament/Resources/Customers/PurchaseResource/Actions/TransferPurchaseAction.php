<?php

namespace App\Filament\Resources\Customers\PurchaseResource\Actions;

use App\Domain\Shop\Actions\TransferPurchaseToUser;
use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class TransferPurchaseAction
{
    public static function make(): Action
    {
        return Action::make('transfer_purchase')
            ->icon('heroicon-o-arrows-right-left')
            ->form([
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
            ])
            ->action(function (array $data, Purchase $record): void {
                $otherUser = User::where('email', $data['email'])->first();

                if (! $otherUser) {
                    Notification::make()
                        ->title("No user found with email {$data['email']}")
                        ->danger()
                        ->send();
                }

                (new TransferPurchaseToUser())->execute($record, $otherUser);

                Notification::make()
                    ->title("Transfer to {$otherUser->name} ({$otherUser->email}) is complete!")
                    ->success()
                    ->send();
            });
    }
}

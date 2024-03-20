<?php

namespace App\Filament\Resources\Customers\UserResource\Actions;

use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Laravel\Paddle\Receipt;

class TransferPurchaseToUserAction
{
    public static function make()
    {
        return Action::make('transfer_purchases_to_user')
            ->icon('heroicon-o-user-plus')
            ->form([
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
            ])
            ->action(function (array $data, User $record): void {
                $otherUser = User::where('email', $data['email'])->first();
                $user = $record;

                if (! $otherUser) {
                    Notification::make()
                        ->title("No user found with email {$data['email']}")
                        ->danger()
                        ->send();
                }

                $user->purchases->each(function (Purchase $purchase) use ($otherUser) {
                    $purchase->update(['user_id' => $otherUser->id]);
                });

                $user->receipts->each(function (Receipt $receipt) use ($otherUser) {
                    $receipt->update(['billable_id' => $otherUser->id]);
                });

                Notification::make()
                    ->title("All purchases transfered to {$otherUser->name} ({$otherUser->email})!")
                    ->success()
                    ->send();
            });
    }
}

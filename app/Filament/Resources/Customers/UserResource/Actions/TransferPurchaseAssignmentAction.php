<?php

namespace App\Filament\Resources\Customers\UserResource\Actions;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class TransferPurchaseAssignmentAction
{
    public static function make()
    {
        return Action::make('transfer_purchase_assignments')
            ->icon('heroicon-o-arrows-right-left')
            ->schema([
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
            ])
            ->action(function (array $data, User $record): void {
                $otherUser = User::where('email', $data['email'])->first();

                if (! $otherUser) {
                    Notification::make()
                        ->title("No user found with email {$data['email']}")
                        ->danger()
                        ->send();
                }

                $record->assignments->each(function (PurchaseAssignment $assignment) use ($otherUser) {
                    $assignment->update(['user_id' => $otherUser->id]);
                });

                Notification::make()
                    ->title("All purchase assignments transferred to {$otherUser->name} ({$otherUser->email})!")
                    ->success()
                    ->send();
            });
    }
}

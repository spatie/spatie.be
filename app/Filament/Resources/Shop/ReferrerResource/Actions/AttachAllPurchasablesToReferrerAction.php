<?php

namespace App\Filament\Resources\Shop\ReferrerResource\Actions;

use Filament\Actions\Action;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;

class AttachAllPurchasablesToReferrerAction
{
    public static function make()
    {
        return Action::make('attach_all_purchasables')
            ->icon('heroicon-o-link')
            ->color('warning')
            ->requiresConfirmation()
            ->action(function (Referrer $record) {
                $purchasables = Purchasable::all();
                $record->purchasables()->sync($purchasables);
            });
    }
}

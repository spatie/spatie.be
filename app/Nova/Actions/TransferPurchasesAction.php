<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Actions\TransferPurchaseToUser;
use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;

class TransferPurchasesAction extends DestructiveAction
{
    public $name = 'Transfer Purchase';

    public function handle(ActionFields $fields, Collection $models)
    {
        $otherUser = User::where('email', $fields->get('email'))->first();

        if (! $otherUser) {
            return Action::danger("No user found with email {$fields->get('email')}");
        }

        $models->each(function(Purchase $purchase) use ($otherUser) {
            (new TransferPurchaseToUser())->execute($purchase, $otherUser);
        });

        return Action::message("Transfer to {$otherUser->name} ({$otherUser->email}) is complete!");
    }

    public function fields()
    {
        return [
            Text::make('Email')->required(),
        ];
    }
}

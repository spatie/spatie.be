<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Paddle\Receipt;

class TransferPurchasesToUser extends DestructiveAction
{
    public $name = 'Transfer Purchases';

    public function handle(ActionFields $fields, Collection $models)
    {
        $otherUser = User::where('email', $fields->get('email'))->first();

        if (! $otherUser) {
            return Action::danger("No user found with email {$fields->get('email')}");
        }

        $models->each(function (User $user) use ($otherUser) {
            $user->purchases->each(function (Purchase $purchase) use ($otherUser) {
                $purchase->update(['user_id' => $otherUser->id]);
            });

            $user->receipts->each(function (Receipt $receipt) use ($otherUser) {
                $receipt->update(['billable_id' => $otherUser->id]);
            });
        });

        return Action::message("All purchases transfered to {$otherUser->name} ({$otherUser->email})!");
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Email')->required(),
        ];
    }
}

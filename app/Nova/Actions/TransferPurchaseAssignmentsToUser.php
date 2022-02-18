<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;

class TransferPurchaseAssignmentsToUser extends DestructiveAction
{
    public $name = 'Transfer Purchase Assignments';

    public function handle(ActionFields $fields, Collection $models)
    {
        $otherUser = User::where('email', $fields->get('email'))->first();

        if (! $otherUser) {
            return Action::danger("No user found with email {$fields->get('email')}");
        }

        $models->each(function (User $user) use ($otherUser) {
            $user->assignments->each(function (PurchaseAssignment $assignment) use ($otherUser) {
                $assignment->update(['user_id' => $otherUser->id]);
            });
        });

        return Action::message("All purchase assignments transfered to {$otherUser->name} ({$otherUser->email})!");
    }

    public function fields()
    {
        return [
            Text::make('Email')->required(),
        ];
    }
}

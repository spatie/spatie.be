<?php

namespace App\Nova;

use App\Nova\Actions\TransferPurchaseAssignmentsToUser;
use App\Nova\Actions\TransferPurchasesToUser;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $title = 'name';

    public static $group = 'Users';

    public static $search = [
        'id', 'name', 'email', 'github_username',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Email')
                ->sortable()
                ->rules(['required', 'email', 'max:254'])
                ->creationRules(['unique:users,email'])
                ->updateRules(['unique:users,email,{{resourceId}}']),

            Boolean::make('Has access to unreleased products'),

            Text::make('GitHub username')->readonly(),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules(['required', 'string', 'min:8'])
                ->updateRules(['nullable', 'string', 'min:8']),

            Boolean::make('Is admin'),
            Boolean::make('Is sponsor')->readonly(),

            HasMany::make('Purchases'),
            HasMany::make('Purchase Assignments', 'assignments', PurchaseAssignment::class),
            HasMany::make('Licenses'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new TransferPurchasesToUser(),
            new TransferPurchaseAssignmentsToUser(),
        ];
    }
}

<?php

namespace App\Nova;

use Illuminate\Http\Request;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $title = 'name';

    public static $group = 'Users';

    public static $search = [
        'id', 'name', 'email', 'github_username',
    ];

    public function fields(Request $request)
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

            Impersonate::make($this)->withMeta([
                'redirect_to' => route('profile'),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}

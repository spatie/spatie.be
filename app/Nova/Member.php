<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Member extends Resource
{
    public static $model = \App\Models\Member::class;

    public static $title = 'first_name';

    public static $group = 'Team Members';

    public static $search = [
        'id', 'first_name', 'email', 'preferred_name',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('First Name')
                ->sortable()
                ->required()
                ->rules(['required', 'max:255']),

            Text::make('Last Name')
                ->sortable()
                ->required()
                ->rules(['required', 'max:255']),

            Text::make('Preferred Name')
                ->sortable()
                ->nullable()
                ->rules(['required', 'max:255']),

            Textarea::make('Description')
                ->hideFromIndex()
                ->sortable()
                ->nullable()
                ->rules(['required']),

            Text::make('Email')
                ->sortable()
                ->rules(['required', 'email', 'max:254'])
                ->creationRules(['unique:members,email'])
                ->updateRules(['unique:members,email,{{resourceId}}']),

            Boolean::make('Public email'),

            Date::make('Birthday')
                ->sortable()
                ->nullable(),

            Text::make('Twitter')
                ->nullable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Text::make('Github')
                ->nullable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Text::make('Website')
                ->nullable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),
        ];
    }
}

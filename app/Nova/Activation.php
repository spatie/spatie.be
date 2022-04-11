<?php

namespace App\Nova;

use App\Domain\Shop\Models\Activation as EloquentActivation;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Activation extends Resource
{
    public static $group = "Products";

    public static $model = EloquentActivation::class;

    public static $displayInNavigation = false;

    //public static $title = 'title';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('License'),

            Text::make('Name'),
        ];
    }
}

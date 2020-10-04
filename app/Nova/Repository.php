<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;

class Repository extends Resource
{
    public static $model = \App\Models\Repository::class;

    public static $title = 'name';

    public static $group = "GitHub";

    public static $defaultSort = 'name';

    public static $search = [
       'name', 'description',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Ad'),

            Boolean::make('Ad should be randomized'),
        ];
    }
}

<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;

class Release extends Resource
{
    public static $model = \App\Models\Release::class;

    public static $title = 'version';

    public static $group = "Products";


    public static $search = [
        'id', 'version', 'notes',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product'),

            Text::make('Version'),

            Boolean::make('Released')->default(false),

            DateTime::make('Released at'),


            Markdown::make('Notes'),
        ];
    }
}

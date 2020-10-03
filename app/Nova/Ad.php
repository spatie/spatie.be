<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class Ad extends Resource
{
    public static $model = \App\Models\Ad::class;

    public static $title = 'name';

    public static $group = "GitHub";

    public static $search = [
       'name',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Image::make('Image')->disk('public'),

            Text::make('Url')->rules('required', 'max:255'),

            HasMany::make('Repositories'),
        ];
    }
}

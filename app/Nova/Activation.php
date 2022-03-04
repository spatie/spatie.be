<?php

namespace App\Nova;

use App\Domain\Shop\Models\Activation as EloquentActivation;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Activation extends Resource
{
    public static $group = "Products";

    public static $model = EloquentActivation::class;

    public static $displayInNavigation = false;

    //public static $title = 'title';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('License'),

            Text::make('Name'),
        ];
    }
}

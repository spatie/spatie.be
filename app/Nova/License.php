<?php

namespace App\Nova;

use App\Models\License as EloquentLicense;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class License extends Resource
{
    public static $group = "Products";

    public static $model = EloquentLicense::class;

    public static $title = 'key';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('User'),

            Text::make('Key')->hideFromIndex(),
            Number::make('Satis Authentication Count'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Domain\Shop\Models\License as EloquentLicense;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class License extends Resource
{
    public static $group = "Products";

    public static $model = EloquentLicense::class;

    public static $title = 'key';

    public static $search = [
        'id', 'key', 'domain',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('Purchase'),
            BelongsTo::make('User'),

            Text::make('Key')->hideFromIndex(),
            Number::make('Satis Authentication Count'),

            DateTime::make('expires_at'),
        ];
    }
}

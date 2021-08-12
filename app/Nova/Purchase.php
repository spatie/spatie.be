<?php

namespace App\Nova;

use App\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Purchase extends Resource
{
    public static $group = "Products";

    public static $model = EloquentPurchase::class;

    //public static $title = 'title';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Paddle Fee')->hideFromIndex(),
            Text::make('Earnings')->hideFromIndex(),

            Boolean::make('Has repository access')->readonly(),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('Bundle'),
            HasMany::make('Licenses')->hideFromIndex()->nullable(),
            BelongsTo::make('User'),
            BelongsTo::make('Receipt')->nullable()->hideFromIndex(),

            DateTime::make('Created at'),
        ];
    }
}

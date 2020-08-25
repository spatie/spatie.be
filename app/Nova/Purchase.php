<?php

namespace App\Nova;

use App\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Purchase extends Resource
{
    public static $group = "Products";

    public static $model = EloquentPurchase::class;

    //public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Paddle Fee'),
            Text::make('Earnings'),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('License')->nullable(),
            BelongsTo::make('User'),
            BelongsTo::make('Receipt'),
        ];
    }
}

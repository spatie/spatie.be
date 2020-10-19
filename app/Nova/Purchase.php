<?php

namespace App\Nova;

use App\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
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

            Text::make('Paddle Fee'),
            Text::make('Earnings'),

            Boolean::make('Has repository access')->readonly(),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('License')->nullable(),
            BelongsTo::make('User'),
            BelongsTo::make('Receipt'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Domain\Shop\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            BelongsTo::make('User'),
            BelongsTo::make('Purchasable'),
            BelongsTo::make('Bundle'),

            Text::make('Paddle Fee')->hideFromIndex(),
            Text::make('Earnings')->hideFromIndex(),

            HasMany::make('Purchase Assignments', 'assignments', PurchaseAssignment::class),

            Number::make('Quantity'),
            BelongsTo::make('Receipt')->nullable()->hideFromIndex(),

            DateTime::make('Created at'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Purchase extends Resource
{
    use HasSortableRows;

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

            BelongsTo::make('Purchasable'),
            BelongsTo::make('License'),
            BelongsTo::make('User'),

            Text::make('Payment Method'),
            Text::make('Receipt URL'),
            Number::make('Paddle Fee'),
            Number::make('Payment Tax'),
            Number::make('Earnings'),
            Number::make('Paddle Alert ID'),
        ];
    }
}

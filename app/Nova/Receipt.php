<?php

namespace App\Nova;

use App\Models\Purchase as EloquentPurchase;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Paddle\Receipt as PaddleReceipt;

class Receipt extends Resource
{
    public static $group = "Products";

    public static $model = PaddleReceipt::class;

    //public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Number::make('Amount'),
            Number::make('Tax'),
            Text::make('Currency'),
            Text::make('Receipt Url'),
        ];
    }
}

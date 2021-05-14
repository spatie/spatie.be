<?php

namespace App\Nova;

use Illuminate\Http\Request;
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
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Receipt Url'),
            Number::make('Amount'),
            Number::make('Tax')->hideFromIndex(),
            Text::make('Currency'),
        ];
    }
}

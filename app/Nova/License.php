<?php

namespace App\Nova;

use App\Models\License as EloquentLicense;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class License extends Resource
{
    use HasSortableRows;

    public static $group = "Products";

    public static $model = EloquentLicense::class;

    //public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchasable'),
            BelongsTo::make('User'),

            Text::make('Key'),
            Number::make('Satis Authentication Count'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Domain\Shop\Models\PurchaseAssignment as EloquentPurchaseAssignment;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;

class PurchaseAssignment extends Resource
{
    public static $group = "Sales";

    public static $displayInNavigation = false;

    public static $model = EloquentPurchaseAssignment::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchase'),
            BelongsTo::make('Purchasable'),
            BelongsTo::make('User'),
            HasMany::make('Licenses'),

            Boolean::make('Has repository access')->readonly(),

            DateTime::make('Created at'),
        ];
    }
}

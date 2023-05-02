<?php

namespace App\Nova;

use App\Domain\Shop\Models\PurchaseAssignment as EloquentPurchaseAssignment;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class PurchaseAssignment extends Resource
{
    public static $group = "Sales";

    public static $displayInNavigation = false;

    public static $model = EloquentPurchaseAssignment::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchase')->searchable(),
            BelongsTo::make('Purchasable')->searchable(),
            BelongsTo::make('User')->displayUsing(function (User $user) {
                return $user->name . ' - ' . $user->email;
            })->searchable(),
            HasMany::make('Licenses'),

            Boolean::make('Has repository access')->readonly(),

            DateTime::make('Created at'),
        ];
    }
}

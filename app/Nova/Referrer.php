<?php

namespace App\Nova;

use App\Nova\Actions\AttachAllPurchasablesToReferrerAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Referrer extends Resource
{
    public static $model = \App\Domain\Shop\Models\Referrer::class;

    public static $title = 'slug';

    public static $group = "Referrers";

    public static $search = [
        'id', 'slug', 'uuid',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('slug')
                ->rules(['required', 'max:255', 'unique:referrers'])
                ->displayUsing(function (string $slug) {
                    return url("/products?referrer={$slug}");
                })
                ->help("Add '?referrer=slug' to the URL to use this referrer"),

            Text::make('Uuid')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->readonly(),

            BelongsToMany::make('Purchasables'),

            new Panel('Discount', [
                Text::make('Percentage', 'discount_percentage')
                    ->default(0)
                    ->help('The discount percentage'),
                DateTime::make('Expires at', 'discount_period_ends_at')->nullable()->hideFromIndex()->help('Not specifying this field will make the discount active indefinitely'),
            ]),

            new Panel('Clicks', [
                Number::make('Click count')->readonly(),

                DateTime::make('Last clicked at')->readonly(),
            ]),

            BelongsToMany::make('Purchases', 'usedForPurchases'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new AttachAllPurchasablesToReferrerAction()),
        ];
    }
}

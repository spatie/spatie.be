<?php

namespace App\Nova;

use App\Domain\Shop\Models\BundlePrice as EloquentBundlePrice;
use App\Nova\Filters\BundleFilter;
use App\Support\Paddle\PaddleCountries;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

;

class BundlePrice extends Resource
{


    public static $group = "Products";

    public static $tableStyle = 'tight';

    public static $model = EloquentBundlePrice::class;

    public static $title = 'country_code';

    public static $perPageViaRelationship = 30;

    public static $search = [
        'currency_code', 'country_code',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('bundle'),

            Text::make('Country', 'country_code')->readonly()->displayUsing(function (string $countryCode) {
                return PaddleCountries::getNameForCode($countryCode) . " (${countryCode})";
            }),

            Text::make('Currency code')->readonly(),

            Number::make('Price in cents', 'amount'),

            Boolean::make('Overridden')->help('When checked, this price will not be automatically updated'),
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new BundleFilter(),
        ];
    }
}

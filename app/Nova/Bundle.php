<?php

namespace App\Nova;

use App\Domain\Shop\Models\Bundle as EloquentBundle;
use App\Nova\Actions\UpdateBundlePriceForCurrencyAction;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

;

class Bundle extends Resource
{
    public static $group = "Products";

    public static $model = EloquentBundle::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Image::make('Image')
                ->store(function (NovaRequest $request, EloquentBundle $product) {
                    return function () use ($request, $product): void {
                        $product
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection('image');
                    };
                })
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentBundle $product) {
                    $product->deleteMedia($product->getFirstMedia('image'));

                    return [];
                }),

            Text::make('Title')
                ->sortable()
                ->rules(['required', 'max:255']),
            Text::make('Slug')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Text::make('Paddle id', 'paddle_product_id')
                ->sortable()
                ->rules(['required', 'max:255']),

            Markdown::make('Description'),
            Markdown::make('Long Description'),

            Number::make('Price in USD cents')
                ->required()
                ->showOnIndex(),

            Boolean::make('Visible on front', 'visible'),

            BelongsToMany::make('Purchasables', 'purchasables', Purchasable::class),
            HasMany::make('Prices', 'prices', BundlePrice::class),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new UpdateBundlePriceForCurrencyAction())
                ->showOnTableRow()
                ->confirmButtonText('Update price'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Models\Product as EloquentProduct;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Product extends Resource
{
    use HasSortableRows;

    public static $group = "Products";

    public static $model = EloquentProduct::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Slug')
                ->sortable()
                ->rules(['required', 'max:255']),

            Image::make('Image')
                ->store(function (Request $request, EloquentProduct $product) {
                    return function () use ($request, $product): void {
                        $product
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection('product-image');
                    };
                })
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentProduct $product) {
                    $product->deleteMedia($product->getFirstMedia('product-image'));

                    return [];
                }),

            Markdown::make('Description'),
            Markdown::make('Long Description'),

            Boolean::make('Visible on front', 'visible'),
            Boolean::make('External'),
            Text::make('Url')->hideFromIndex(),
            Text::make('Action url')->hideFromIndex(),
            Text::make('Action label')->hideFromIndex(),

            new Panel('Coupon', [
                Text::make('Code', 'coupon_code')->hideFromIndex()->help('Make sure you have defined this code in Paddle too'),
                Text::make('Label', 'coupon_label')->hideFromIndex(),
                Number::make('Percentage', 'coupon_percentage')->hideFromIndex(),
                DateTime::make('Valid from', 'coupon_valid_from')->hideFromIndex(),
                DateTime::make('Expires at', 'coupon_expires_at')->hideFromIndex()->help('Not specifying this field will make the coupon active indefinitely'),
            ]),

            HasMany::make('Purchasables', 'purchasables', Purchasable::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}

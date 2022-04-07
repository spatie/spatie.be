<?php

namespace App\Nova;

use App\Domain\Shop\Models\Product as EloquentProduct;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    public static $group = "Products";

    public static $model = EloquentProduct::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public static $with = ['purchasablesWithoutRenewals', 'renewals'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Image::make('Image')
                ->store(function (NovaRequest $request, EloquentProduct $product) {
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

            Text::make('Title')
                ->sortable()
                ->rules(['required', 'max:255']),
            Text::make('Slug')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Markdown::make('Description'),
            Markdown::make('Long Description'),

            Boolean::make('Visible on front', 'visible'),
            Boolean::make('External')->hideFromIndex(),
            Text::make('Url')->hideFromIndex(),
            Text::make('Action url')->hideFromIndex(),
            Text::make('Action label')->hideFromIndex(),

            Number::make('Maximum activation count')
                ->hideFromIndex()
                ->help('Set to 0 if the product does not support activations'),

            HasMany::make('Purchasables', 'purchasables', Purchasable::class),
            Text::make('Purchasables', function () {
                if (! $this->purchasablesWithoutRenewals->count()) {
                    return "&mdash;";
                }

                return $this->purchasablesWithoutRenewals->map(function (\App\Domain\Shop\Models\Purchasable $purchasable) {
                    $resource = (new Purchasable($purchasable));
                    $url = '/nova/resources/'.$resource::uriKey().'/'.$resource->getKey();

                    return <<<HTML
                        <p class="my-1">
                            <a class='no-underline dim text-primary font-bold' href='{$url}'>
                                {$purchasable->title}
                            </a>
                        </p>
                    HTML;
                })->join("\n");
            })->onlyOnIndex()->asHtml(),

            Text::make('Renewals', function () {
                if (! $this->renewals->count()) {
                    return "&mdash;";
                }

                return $this->renewals->map(function (\App\Domain\Shop\Models\Purchasable $purchasable) {
                    $resource = (new Purchasable($purchasable));
                    $url = '/nova/resources/'.$resource::uriKey().'/'.$resource->getKey();

                    return <<<HTML
                        <p class="my-1">
                            <a class='no-underline dim text-primary font-bold' href='{$url}'>
                                {$purchasable->title}
                            </a>
                        </p>
                    HTML;
                })->join("\n");
            })->onlyOnIndex()->asHtml(),
        ];
    }
}

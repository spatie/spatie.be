<?php

namespace App\Nova;

use App\Domain\Shop\Models\Bundle as EloquentBundle;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Bundle extends Resource
{
    use HasSortableRows;

    public static $group = "Products";

    public static $model = EloquentBundle::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Image::make('Image')
                ->store(function (Request $request, EloquentBundle $product) {
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
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}

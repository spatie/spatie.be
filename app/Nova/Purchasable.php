<?php

namespace App\Nova;

use App\Enums\PurchasableType;
use App\Models\Purchasable as EloquentPurchasable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Purchasable extends Resource
{
    use HasSortableRows;

    public static $group = "Products";

    public static $model = EloquentPurchasable::class;

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
                ->rules('required', 'max:255'),

            BelongsTo::make('Purchasable for renewal', 'renewalPurchasable', Purchasable::class)
                ->nullable(),

            BelongsTo::make('Product'),

            BelongsToMany::make('Series'),

            Text::make('Paddle id', 'paddle_product_id')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Type')->options(PurchasableType::getLabels()) ->rules('required'),

            Image::make('Image')
                ->store(function (Request $request, EloquentPurchasable $product) {
                    return function () use ($request, $product) {
                        $product
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection('purchasable-image');
                    };
                })
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentPurchasable $product) {
                    $product->deleteMedia($product->getFirstMedia('purchasable-image'));

                    return [];
                }),

            Markdown::make('Description'),
            Boolean::make('Requires license'),

            Files::make('Downloads')
                ->customPropertiesFields([
                    Text::make('Label'),
                ]),

            Text::make('Repository access'),

            Text::make('Sponsor coupon')->help('For display purposes only, you still need to create this in Paddle.'),
        ];
    }
}

<?php

namespace App\Nova;

use App\Enums\PurchasableType;
use App\Models\Purchasable as EloquentPurchasable;
use App\Nova\Actions\UpdatePriceForCurrencyAction;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use NovaItemsField\Items;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Purchasable extends Resource
{
    use HasSortableRows;

    public static $group = "Products";

    public static $model = EloquentPurchasable::class;

    public static $search = [
        'id', 'title',
    ];

    public function title()
    {
        return "{$this->title} ({$this->product->title})";
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules(['required', 'max:255']),

            Number::make('Price in USD cents')
                ->required()
                ->showOnIndex(),

            new Panel('Discount', [
                Text::make('Percentage', 'discount_percentage')->nullable()->help('The discount percentage to be displayed'),
                Text::make('Name', 'discount_name')->hideFromIndex()->help('The reason for the discount'),
                DateTime::make('Starts at', 'discount_starts_at')->nullable()->hideFromIndex(),
                DateTime::make('Expires at', 'discount_expires_at')->nullable()->hideFromIndex()->help('Not specifying this field will make the coupon active indefinitely'),
            ]),

            HasMany::make('Purchasable prices', 'prices'),

            Boolean::make('Released'),

            BelongsTo::make('Purchasable for renewal', 'renewalPurchasable', Purchasable::class)
                ->hideFromIndex()
                ->nullable(),

            BelongsTo::make('Product'),

            BelongsToMany::make('Series'),

            Text::make('Paddle id', 'paddle_product_id')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Text::make('Getting started URL')
                ->sortable()
                ->hideFromIndex()
                ->rules(['max:255']),

            Select::make('Type')
                ->options(PurchasableType::getLabels())
                ->hideFromIndex()
                ->rules(['required']),

            Image::make('Image')
                ->store(function (Request $request, EloquentPurchasable $product) {
                    return function () use ($request, $product): void {
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
            Boolean::make('Requires license')->hideFromIndex(),

            Files::make('Downloads')
                ->customPropertiesFields([
                    Text::make('Label'),
                ]),

            Text::make('Repository access')->hideFromIndex(),

            Items::make('Satis packages')->hideFromIndex(),
        ];
    }

    public function actions(Request $request)
    {
        return [
            (new UpdatePriceForCurrencyAction())
                ->onlyOnTableRow()
                ->confirmButtonText('Update price'),
        ];
    }
}

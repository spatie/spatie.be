<?php

namespace App\Nova;

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\Purchasable as EloquentPurchasable;
use App\Nova\Actions\UpdatePriceForCurrencyAction;
use App\Nova\Filters\ProductFilter;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Purchasable extends Resource
{
    public static $group = "Products";

    public static $model = EloquentPurchasable::class;

    public static $search = [
        'id', 'title',
    ];

    public function title()
    {
        return "{$this->title} ({$this->product->title})";
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            new Panel('Setup', [
                BelongsTo::make('Product'),

                Select::make('Type')
                    ->options(PurchasableType::getLabels())
                    ->hideFromIndex()
                    ->rules(['required']),

                BelongsTo::make('Purchasable for renewal', 'renewalPurchasable', Purchasable::class)
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Paddle id', 'paddle_product_id')
                    ->sortable()
                    ->hideFromIndex()
                    ->rules(['required', 'max:255']),

                Boolean::make('Released'),

                Boolean::make('Requires license')->hideFromIndex(),
                Boolean::make('Is Lifetime')->hideFromIndex(),

                Text::make('Repository access')->hideFromIndex(),
                Text::make('Satis packages'),
            ]),

            new Panel('Details', [
                Text::make('Title')
                    ->sortable()
                    ->rules(['required', 'max:255']),

                Image::make('Image')
                    ->store(function (NovaRequest $request, EloquentPurchasable $product) {
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

                Number::make('Price in USD cents')
                    ->required()
                    ->showOnIndex(),

                Text::make('Getting started URL')
                    ->sortable()
                    ->hideFromIndex()
                    ->rules(['max:255']),

                Code::make('Getting started description')
                    ->sortable()
                    ->language('html')
                    ->autoHeight()
                    ->hideFromIndex(),

                Code::make('Extra links')
                    ->language('html')
                    ->autoHeight()
                    ->hideFromIndex(),

                Markdown::make('Description'),

                Markdown::make('Renewal mail incentive'),

                Files::make('Downloads')
                    ->customPropertiesFields([
                        Text::make('Label'),
                    ]),
            ]),

            HasMany::make('Purchasable prices', 'prices'),
            BelongsToMany::make('Series'),

            new Panel('Discount', [
                Text::make('Percentage', 'discount_percentage')->nullable()->help('The discount percentage to be displayed'),
                Text::make('Name', 'discount_name')->hideFromIndex()->help('The reason for the discount'),
                DateTime::make('Starts at', 'discount_starts_at')->nullable()->hideFromIndex(),
                DateTime::make('Expires at', 'discount_expires_at')->nullable()->hideFromIndex()->help('Not specifying this field will make the coupon active indefinitely'),
            ]),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new UpdatePriceForCurrencyAction())
                ->onlyOnTableRow()
                ->confirmButtonText('Update price'),
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new ProductFilter(),
        ];
    }
}

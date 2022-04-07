<?php

namespace App\Nova;

use App\Models\Enums\TechnologyType;
use App\Models\Technology as EloquentTechnology;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Technology extends Resource
{
    public static $model = EloquentTechnology::class;

    public static $group = 'Technologies';

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public static array $orderBy = ['type' => 'asc', 'sort_order' => 'asc'];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            Textarea::make('Description')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required']),

            Select::make('Type')
                ->sortable()
                ->nullable(false)
                ->rules(['required'])
                ->options(TechnologyType::toLabels()),

            Text::make('Website Url', 'website_url')
                ->rules(['required', 'max:255', 'url']),

            Image::make('Avatar')
                ->store(function (NovaRequest $request, EloquentTechnology $technology) {
                    return function () use ($request, $technology): void {
                        $technology
                            ->addMedia($request->file('avatar'))
                            ->withResponsiveImages()
                            ->toMediaCollection('avatar');
                    };
                })
                ->thumbnail(function ($value, $disk, EloquentTechnology $technology) {
                    return $technology->getFirstMediaUrl('avatar');
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })
                ->delete(function (NovaRequest $request, EloquentTechnology $technology) {
                    $technology->clearMediaCollection('avatar');

                    return [];
                }),
        ];
    }
}

<?php

namespace App\Nova;

use App\Models\Enums\TechnologyType;
use App\Models\Technology as EloquentTechnology;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use OptimistDigital\MultiselectField\Multiselect;

class Technology extends Resource
{
    public static $model = EloquentTechnology::class;

    public static $group = 'Technologies';

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public function fields(Request $request): array
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

            Multiselect::make('Recommended by')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required'])
                ->saveAsJSON()
                ->options(
                    collect(config('team.members'))->mapWithKeys(function (string $name) {
                        return [$name => ucfirst($name)];
                    })
                ),

            Image::make('Avatar')
                ->store(function (Request $request, EloquentTechnology $technology) {
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
                ->delete(function (Request $request, EloquentTechnology $technology) {
                    $technology->clearMediaCollection('avatar');

                    return [];
                }),
        ];
    }
}

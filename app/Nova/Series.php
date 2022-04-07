<?php

namespace App\Nova;

use App\Models\Series as EloquentSeries;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Series extends Resource
{
    public static $group = "Videos";

    public static $model = EloquentSeries::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsToMany::make('Purchasables'),


            Text::make('Title')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Slug')
                ->sortable()
                ->rules(['required', 'max:255']),

            Markdown::make('Description'),

            Image::make('Image')
                ->store(function (NovaRequest $request, EloquentSeries $series) {
                    return function () use ($request, $series): void {
                        $series
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection('series-image');
                    };
                })
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentSeries $series) {
                    $series->deleteMedia($series->getFirstMedia('series-image'));

                    return [];
                }),

            Markdown::make('Introduction'),

            HasMany::make('Videos', 'videos', Video::class),

            Boolean::make('Visible'),
        ];
    }
}

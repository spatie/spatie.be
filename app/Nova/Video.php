<?php

namespace App\Nova;

use App\Models\Enums\VideoDisplayEnum;
use App\Models\Video as EloquentVideo;
use App\Nova\Filters\SeriesFilter;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

;

class Video extends Resource
{
    public static $group = "Videos";

    public static $model = EloquentVideo::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title', 'chapter',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Series', 'series', Series::class)->sortable(),

            Text::make('Title')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Slug')
                ->sortable()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Runtime')
                ->sortable()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Boolean::make('Downloadable')->hideFromIndex(),

            Image::make('Thumbnail')
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value) {
                    return $value;
                })
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Text::make('Chapter')->hideFromIndex()->sortable(),

            Text::make('vimeo_id')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Number::make('sort_order')
                ->readonly()
                ->hideFromIndex()
                ->sortable(),

            Select::make('Display')
                ->options([
                    VideoDisplayEnum::FREE => 'Free',
                    VideoDisplayEnum::AUTH => 'Logged in users',
                    VideoDisplayEnum::SPONSORS => 'Sponsors & License holders',
                    VideoDisplayEnum::LICENSE => 'Only license holders',
                ])
                ->default('license'),
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new SeriesFilter(),
        ];
    }
}

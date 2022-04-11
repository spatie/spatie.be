<?php

namespace App\Nova;

use App\Models\Video as EloquentVideo;

use App\Nova\Filters\SeriesFilter;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Video extends Resource
{
    public static $group = "Videos";

    public static $model = EloquentVideo::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Chapter')->hideFromIndex()->sortable(),

            Text::make('vimeo_id')
                ->sortable()
                ->hideFromIndex()
                ->rules(['required', 'max:255']),

            Number::make('sort_order')
                ->readonly()
                ->hideFromIndex()
                ->sortable(),
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new SeriesFilter(),
        ];
    }
}

<?php

namespace App\Nova;

use App\Models\Enums\VideoDisplayEnum;
use App\Models\Video as EloquentVideo;
use App\Nova\Filters\SeriesFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Video extends Resource
{
    use HasSortableRows;

    public static $group = "Videos";

    public static $model = EloquentVideo::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Series', 'series', Series::class)->sortable(),

            Text::make('Title')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Slug')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make('Runtime')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Image::make('Thumbnail')
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value) {
                    return $value;
                })
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Text::make('vimeo_id')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Display')
                ->options([
                    VideoDisplayEnum::FREE => 'Free',
                    VideoDisplayEnum::SPONSORS => 'Sponsors & License holders',
                    VideoDisplayEnum::LICENSE => 'Only license holders',
                ])
                ->default('license'),
        ];
    }

    public function filters(Request $request)
    {
        return [
            new SeriesFilter(),
        ];
    }
}

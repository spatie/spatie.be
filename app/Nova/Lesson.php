<?php

namespace App\Nova;

use App\Models\Enums\LessonDisplayEnum;
use App\Models\Lesson as EloquentLesson;
use App\Nova\Filters\SeriesFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Lesson extends Resource
{
    use HasSortableRows;

    public static $group = "Courses";

    public static $model = EloquentLesson::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title', 'chapter',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Series', 'series', Series::class)->sortable(),

            Text::make('Title')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            MorphTo::make('Content')->types([
               Video::class,
               HtmlLesson::class,
            ]),

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
                    LessonDisplayEnum::FREE => 'Free',
                    LessonDisplayEnum::AUTH => 'Logged in users',
                    LessonDisplayEnum::SPONSORS => 'Sponsors & License holders',
                    LessonDisplayEnum::LICENSE => 'Only license holders',
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

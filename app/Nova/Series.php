<?php

namespace App\Nova;

use App\Models\Series as EloquentSeries;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Series extends Resource
{
    use HasSortableRows;

    public static $group = "Videos";

    public static $model = EloquentSeries::class;

    public static $title = 'title';

    public static $search = [
        'id', 'title',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsToMany::make('Purchasables'),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255'),

            Image::make('Image')
                ->store(function (Request $request, EloquentSeries $series) {
                    return function () use ($request, $series) {
                        $series
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection();
                    };
                })
                ->thumbnail(function ($value) {
                    return $value;
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentSeries $series) {
                    $series->deleteMedia($series->getFirstMedia());

                    return [];
                }),

            Markdown::make('Description'),

            HasMany::make('Videos', 'videos', Video::class),
        ];
    }
}

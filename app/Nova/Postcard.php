<?php

namespace App\Nova;

use App\Models\Postcard as EloquentPostcard;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Postcard extends Resource
{
    public static $model = EloquentPostcard::class;

    public static $group = 'Postcards';

    public static $title = 'sender';

    public static $search = [
        'id', 'sender', 'city', 'country',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Sender')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('City')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Country')
                ->sortable()
                ->rules(['required', 'max:255']),

            Image::make('Image')
                ->store(function (NovaRequest $request, EloquentPostcard $postcard) {
                    return function () use ($request, $postcard): void {
                        $postcard
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection();
                    };
                })
                ->thumbnail(function ($value, $disk, EloquentPostcard $postcard) {
                    return $postcard->getFirstMediaUrl('default');
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentPostcard $postcard) {
                    $postcard->deleteMedia($postcard->getFirstMedia());

                    return [];
                }),
        ];
    }
}

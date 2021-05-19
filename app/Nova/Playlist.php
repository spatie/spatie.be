<?php

namespace App\Nova;

use App\Models\Playlist as EloquentPlaylist;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

class Playlist extends Resource
{
    public static $model = EloquentPlaylist::class;

    public static $group = 'Playlists';

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Spotfiy Url', 'spotify_url')
                ->rules(['required', 'max:255', 'url']),

            Text::make('Apple Music Url', 'apple_music_url')
                ->rules(['required', 'max:255', 'url']),

            Image::make('Image')
                ->store(function (Request $request, EloquentPlaylist $playlist) {
                    return function () use ($request, $playlist): void {
                        $playlist
                            ->addMedia($request->file('image'))
                            ->withResponsiveImages()
                            ->toMediaCollection();
                    };
                })
                ->thumbnail(function ($value, $disk, EloquentPlaylist $playlist) {
                    return $playlist->getFirstMediaUrl('default');
                })
                ->preview(function ($value, $disk) {
                    return $value;
                })->delete(function ($request, EloquentPlaylist $playlist) {
                    $playlist->deleteMedia($playlist->getFirstMedia());

                    return [];
                }),
        ];
    }
}

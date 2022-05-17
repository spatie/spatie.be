<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Support\Str;

class MusicController
{
    public function __invoke()
    {
        $playlists = Playlist::query()->get()->sortBy(
            fn (Playlist $playlist) => (int) Str::of($playlist->name)
                ->after('#')
                ->before(':')
                ->toString()
        );

        return view('front.pages.blog.music', ['playlists' => $playlists]);
    }
}
